<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Carbon;
use App\Models\OrderProduct;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class InvoiceController extends Controller
{
    public function invoice($id, $invoice)
    {
        try {
            $order = Order::with(['user', 'orderProducts.product'])->findOrFail($id);

            $expectedInvoiceNo = $order->spk;
            if ($invoice !== $expectedInvoiceNo) {
                abort(404, 'Invoice number does not match with order');
            }

            $invoiceNo = $invoice;
            
            $statusMap = [
                0 => 'Unpaid',
                1 => 'Partial Payment', 
                2 => 'Paid'
            ];
            $paymentStatus = $statusMap[$order->status_pembayaran] ?? 'Unknown';

            $items = $order->orderProducts()->with('product')->get();
            
            $lines = [];
            $subtotalBarang = 0;

            foreach ($items as $item) {
                $product = $item->product;
                $qty = $item->qty;
                $unitPrice = $item->subtotal / max($qty, 1);
                
                $productName = $product->name;
                if ($item->variant_details) {
                    $productName .= ' (' . $item->variant_details . ')';
                }
                
                if ($item->length && $item->width) {
                    $productName .= ' - ' . $item->length . ' x ' . $item->width . ' cm';
                }
                
                $lines[] = [
                    'name' => $productName,
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                    'line_total' => $item->subtotal,
                ];
                
                $subtotalBarang += $item->subtotal;
                
                if ($item->finishing_type && $item->jenis_finishing) {
                    $finishingPrice = 0; 
                    if ($finishingRecord = \App\Models\Finishing::find($item->jenis_finishing)) {
                        $finishingPrice = $finishingRecord->finishing_price * $qty;
                    }
                    
                    if ($finishingPrice > 0) {
                        $lines[] = [
                            'name' => $item->finishing_type,
                            'qty' => $qty,
                            'unit_price' => $finishingPrice / $qty,
                            'line_total' => $finishingPrice,
                        ];
                        $subtotalBarang += $finishingPrice;
                    }
                }
            }

            $expressFee = 0;
            if ($order->express == 1) {
                $expressFee = $subtotalBarang * 0.5;
            }

            $ongkir = $order->ongkir ?? 0;
            
            $promoDiscount = $order->promocode_deduct ?? 0;
            
            $diskonPersen = $order->diskon_persen ?? 0;
            $potonganRp = $order->potongan_rp ?? 0;

            $grandTotal = $subtotalBarang + $expressFee + $ongkir - $promoDiscount;
            
            $paidAmount = $grandTotal - ($order->termin ?? 0);
            $amountDue = $order->termin ?? 0;

            $data = [
                'order' => $order,
                'invoiceNo' => $invoiceNo,
                'date' => Carbon::parse($order->created_at)->format('d/m/Y'),
                'dueDate' => $order->deadline ? Carbon::parse($order->deadline)->format('d/m/Y') : '-',
                'paymentStatus' => $paymentStatus,
                'lines' => $lines,
                'subtotalBarang' => $subtotalBarang,
                'expressFee' => $expressFee,
                'ongkir' => $ongkir,
                'promoDiscount' => $promoDiscount,
                'diskonPersen' => $diskonPersen,
                'potonganRp' => $potonganRp,
                'diskonAmount' => 0,
                'grandTotal' => $grandTotal,
                'paidAmount' => $paidAmount,
                'amountDue' => $amountDue,
                'metodeTransaksi' => $order->metode_transaksi,
                'metodeTransaksiPaid' => $order->metode_transaksi_paid,
            ];

            $pdf = PDF::loadView('landingpage.invoice_market', $data);
            $pdf->setPaper('A4', 'portrait');
            
            return $pdf->stream("invoice_{$invoiceNo}.pdf");

        } catch (\Exception $e) {
            abort(500, 'Failed to generate invoice');
        }
    }
}