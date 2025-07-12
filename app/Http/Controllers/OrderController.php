<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderProducts.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('adminpage.orders.index', compact('orders'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|integer|in:0,1,2,3,4,9'
        ]);

        $statusMessages = [
            0 => 'Status pesanan diubah menjadi belum bayar',
            1 => 'Status pesanan diubah menjadi sudah bayar',
            2 => 'Pesanan dimulai pengerjaannya',
            3 => 'Pesanan dalam proses pengiriman',
            4 => 'Pesanan telah selesai',
            9 => 'Pesanan telah di cancel'
        ];

        DB::beginTransaction();
        try {
            $oldStatus = $order->order_status;
            $newStatus = $request->order_status;
            
            $order->update([
                'order_status' => $newStatus
            ]);
            
            $invoiceNumber = $order->spk ?? 'SPK-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
            
            $this->createStatusNotification($order, $newStatus, $invoiceNumber);
            
            DB::commit();
            
            $message = $statusMessages[$newStatus] ?? 'Status pesanan berhasil diubah!';
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'new_status' => $newStatus
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create notification when order status changes
     */
    private function createStatusNotification($order, $status, $invoiceNumber)
    {
        $notificationData = $this->getNotificationContent($status, $invoiceNumber);
        
        if ($notificationData) {
            $notification = new Notification();
            $notification->timestamps = false;
            $notification->forceFill([
                'user_id' => $order->user_id,
                'notification_type' => 'Pembelian',
                'notification_head' => $notificationData['head'],
                'notification_body' => $notificationData['body'],
                'notification_status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ])->save();
        }
    }

    /**
     * Get notification content based on order status
     */
    private function getNotificationContent($status, $invoiceNumber)
    {
        $notifications = [
            0 => [
                'head' => 'PESANANMU MENUNGGU PEMBAYARAN',
                'body' => "Pesananmu #{$invoiceNumber} sedang menunggu pembayaran. Segera lakukan pembayaran untuk memproses pesananmu. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            1 => [
                'head' => 'PEMBAYARAN PESANANMU TELAH DIKONFIRMASI',
                'body' => "Pembayaran untuk pesananmu #{$invoiceNumber} telah dikonfirmasi. Pesananmu akan segera diproses. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            2 => [
                'head' => 'PESANANMU LAGI DIPRODUKSI',
                'body' => "Pesananmu #{$invoiceNumber} udah di tahap produksi. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            3 => [
                'head' => 'PESANANMU SEDANG DALAM PENGIRIMAN',
                'body' => "Pesananmu #{$invoiceNumber} sedang dalam proses pengiriman. Pastikan kamu siap menerima pesananmu. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            4 => [
                'head' => 'PESANANMU TELAH SELESAI',
                'body' => "Selamat! Pesananmu #{$invoiceNumber} telah selesai dan sampai tujuan. Terima kasih telah mempercayai layanan kami. Jangan lupa berikan review ya!"
            ],
            9 => [
                'head' => 'PESANANMU TELAH DIBATALKAN',
                'body' => "Maaf, pesananmu #{$invoiceNumber} telah dibatalkan. Jika ada pertanyaan, silakan hubungi customer service kami. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ]
        ];

        return $notifications[$status] ?? null;
    }

    /**
     * Update order via AJAX
     */
    public function update(Request $request, Order $order)
    {
        $rules = [
            'spk'               => ['nullable', 'string', 'max:100', Rule::unique('orders')->ignore($order->id)],
            'user_id'           => 'required|exists:users,id',
            'transaction_type'  => 'nullable|integer',
            'transaction_method'=> 'nullable|integer|in:0,1,2',
            'paid_at'           => 'nullable|date',
            'payment_status'    => 'required|integer|in:0,1',
            'order_status'      => 'required|integer|in:0,1,2,3,4,9',
            'subtotal'          => 'required|integer|min:0',
            'diskon_persen'     => 'nullable|numeric|min:0|max:100',
            'potongan_rp'       => 'nullable|numeric|min:0',
            'promocode_deduct'  => 'nullable|numeric|min:0',
            'express'           => 'nullable|integer|in:0,1',
            'kurir'             => 'nullable|string|max:255',
            'ongkir'            => 'nullable|integer|min:0',
            'kebutuhan_proofing'=> 'nullable|integer|in:0,1',
            'proof_qty'         => 'nullable|integer|min:0',
            'pickup_status'     => 'nullable|integer|in:0,1',
            'notes'             => 'nullable|string|max:1000',
        ];
        
        if ($request->express == 1) {
            $rules['waktu_deadline'] = 'required|date_format:H:i';
        } else {
            $rules['waktu_deadline'] = 'nullable|date_format:H:i';
        }
        
        $validated = $request->validate($rules);
        
        if ($validated['express'] == 0) {
            $validated['waktu_deadline'] = null;
        }

        DB::beginTransaction();
        try {
            $oldStatus = $order->order_status;
            $newStatus = $validated['order_status'];
            
            $order->update($validated);
            
            if ($oldStatus != $newStatus) {
                $invoiceNumber = $order->spk ?? 'SPK-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
                $this->createStatusNotification($order, $newStatus, $invoiceNumber);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diperbarui.',
                'order' => $order->load(['user', 'orderProducts.product'])
            ]);
                
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order details for editing
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'orderProducts.product']);
        
        return response()->json([
            'success' => true,
            'order' => $order,
            'current_user' => $order->user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            if ($order->order_design && \Storage::disk('public')->exists($order->order_design)) {
                \Storage::disk('public')->delete($order->order_design);
            }
            
            if ($order->preview_design && \Storage::disk('public')->exists($order->preview_design)) {
                \Storage::disk('public')->delete($order->preview_design);
            }

            $order->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dihapus.'
            ]);
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}