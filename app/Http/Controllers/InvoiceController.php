<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Carbon;
use App\Models\OrderProduct;

class InvoiceController extends Controller
{
    public function invoice($id)
    {
        $order = Order::findOrFail($id);

        $rawSpk = explode('-', $order->spk)[0];

        $invoiceNo = 'INV' . substr($rawSpk, 3);

        $statusMap = [0=>'Unpaid',1=>'Partial',2=>'Paid'];
        $paymentStatus = $statusMap[$order->status_pembayaran] ?? 'Unknown';

        $items = OrderProduct::where('order_id', $order->spk)
            ->join('products','order_products.jenis_bahan','=','products.id')
            ->join('orders','orders.spk','=','order_products.order_id')
            ->join('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
            ->select([
                'orders.metode_transaksi',
                'orders.termin',
                'orders.express',
                'finishings.*',
                'orders.potongan_rp',
                'order_products.panjang',
                'order_products.lebar',
                'order_products.jumlah_pesanan',
                'products.name as product_name',
                'products.price as product_price', // harga per m²
                'products.long_product as product_long',
                'products.width_product as product_width',
                'products.additional_size as additional_size',
                'products.additional_unit as additional_unit'
            ])->get();

        $grandTotal = 0;
        $lines = [];

        foreach($items as $it) {
            $finishing = 0;

            if($it->finishing_price>=0){
                $finishing = $it->finishing_price;
            }
            // dd($finishing);
            $pan = 0;
            $leb = 0; 
            if (isset($it->panjang) && $it->panjang !== null && $it->panjang !== '') {
                $panjang_dari_db = $it->panjang / 100; 
                
                if ($panjang_dari_db < $it->product_width) {
                    $pan = $it->product_width / 100; 
                } else {
                    $pan = $panjang_dari_db; 
                }
            }
            if (isset($it->lebar) && $it->lebar !== null && $it->lebar !== '') {
                $lebar_dari_db = $it->lebar / 100; 
                
                if ($lebar_dari_db < $it->product_width) {
                    $leb = $it->product_width / 100; 
                } else {
                    $leb = $lebar_dari_db; 
                }
            }

            $qty = $it->jumlah_pesanan;
            $unit = $it->product_price;

            // Hitung sub hanya jika panjang dan lebar tersedia, jika tidak, sub menjadi 0
            if ($pan > 0 && $leb > 0) {
                $sub = (($pan * $leb) * $unit) + $finishing;
            } else {
                $sub = ($unit * $qty)  + $finishing; // Misalnya, hitung subtotal berdasarkan harga satuan dan kuantitas saja
            }

            $grandTotal += $sub;

            $lines[] = [
                'name'        => $it->product_name,
                'additional_size'        => $it->additional_size,
                'additional_unit'        => $it->additional_unit,
                'qty'         => $qty,
                'unit_price'  => $unit,
                'disc_percent'=> 0,
                'line_total'  => $sub,
                'long_order'    => $it->panjang,
                'width_order'   => $it->lebar
            ];

             $lines[] = [
                'name'        => $it->finishing_name,
                'additional_size' => null,
                'additional_unit' => null,
                'qty'         => 1,
                'unit_price'  => $it->finishing_price,
                'line_total'  => $it->finishing_price,
                'long_order'  => null,
                'width_order' => null,
            ];
        }

        // --- Tambahkan logika ini setelah loop selesai dan $grandTotal sudah terakumulasi ---
        if ($order->express == 1) {
            $grandTotal = $grandTotal + (0.50 * $grandTotal);
        }

        if ($order->metode_pengiriman == 1) {
            $grandTotal = $grandTotal + $order->ongkir;
        }
        
        $potonganDiskonAmt = 0;
        if ($order->diskon_persen) {
            $grandTotal = $grandTotal - $order->ongkir ?? 0;
            $potonganDiskonAmt = $grandTotal * ($order->diskon_persen / 100);
        }
        // ----------------------------------------------------------------------------------
        // dd($order->metode_transaksi);
        $data = compact(
            'order','invoiceNo'
        ) + [
            'date'          => Carbon::parse($order->tanggal)->format('d/m/Y'),
            'dueDate'       => Carbon::parse($order->deadline)->format('d/m/Y'),
            'paymentStatus' => $paymentStatus,
            'lines'         => $lines,
            'grandTotal'    => $grandTotal,
            'subtotal'      => $order->subtotal,
            'metodeTransaksi'=> $order->metode_transaksi,
            'metodeTransaksiPaid'=> $order->metode_transaksi_paid,
            'termin'        => $order->termin,
            'express'       => $order->express,
            'potongan_rp'   => $order->potongan_rp,
            'diskon_persen' => $order->diskon_persen,
            'potonganDiskonAmt' => $potonganDiskonAmt
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('order.invoice', $data);
        return $pdf->stream("invoice_{$invoiceNo}.pdf");
    }
}
