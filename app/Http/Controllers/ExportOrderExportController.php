<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\OrderExport;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Label;

class ExportOrderExportController extends Controller
{
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function orderExport(Request $request)
    {
        $datas = [];
        $query = DB::table('orders as o');
        $query->select(
            'o.spk',
            'o.tanggal',
            'o.waktu',
            'o.nama_pelanggan',
            'o.kontak_pelanggan',
            'o.email_pelanggan',
            'op.jenis_cetakan',
            'op.jenis_bahan',
            'op.panjang',
            'op.lebar',
            'op.jumlah_pesanan',
            'p.price',
            'p.long_product', 
            'p.width_product', 
            'p.additional_size', 
            'p.additional_unit', 
            'p.min_qty', 
            'p.max_qty', 
            'p.name', 
            'o.subtotal',
            'o.potongan_rp',
            'o.diskon_persen',
            'o.ongkir',
            'o.metode_transaksi',
            'op.jenis_finishing',
            'o.kebutuhan_proofing',
            'o.express',
            'o.deadline',
            // 'o.desain',
            'o.proses_proofing',
            'o.proses_produksi',
            'o.proses_finishing',
            'o.quality_control',
            'o.status_pengerjaan',
            'o.payment_at',
            'o.status_pembayaran',
            'o.pickup',
            'o.termin'
        );
        $query->join('order_products as op', 'op.order_id', '=', 'o.spk')
              ->join('products as p', 'p.id', '=', 'op.jenis_bahan')
              ->join('labels as l', 'l.id', '=', 'op.jenis_cetakan');

        if (!empty($request->start_date)) {
            $startDate = Carbon::parse($request->start_date)->toDateString();
            $query->where('o.tanggal', '>=', $startDate);
        }

        if (!empty($request->end_date)) {
            $endDate = Carbon::parse($request->end_date)->toDateString();
            $query->where('o.tanggal', '<=', $endDate);
        }

        if ($request->status_pengerjaan != 'semua') {
            $query->where('o.status_pengerjaan', $request->status_pengerjaan);
        }

        $query->orderBy('spk', 'ASC');

        $results = $query->get();

        if ($results->isNotEmpty()) {
            $datas = $this->dataFormated($results);
        }

        $fileName = 'orders_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new OrderExport(collect($datas)), $fileName);
    }

    public function dataFormated($datas)
    {
        $formatedData = [];
        foreach ($datas as $index => $data) {
            $itemParts = [];

            if ($data->long_product && $data->width_product) {
                $itemParts[] = "{$data->long_product} x {$data->width_product}";
            }

            if ($data->additional_size && $data->additional_unit) {
                $itemParts[] = "{$data->additional_size} {$data->additional_unit}";
            }

            if ($data->min_qty && $data->max_qty) {
                $unitNames = [
                    1 => 'Gram',
                    2 => 'Kilogram',
                    3 => 'cm',
                    4 => 'm',
                    5 => 'm2',
                    6 => 'Lembar',
                    7 => 'Rim',
                    8 => 'pcs'
                ];
                $unit = $unitNames[$data->name] ?? '';
                $itemParts[] = "Pembelian {$data->min_qty}-{$data->max_qty} {$unit}";
            }

            $productName = $this->getProductData($data->jenis_bahan)->name ?? '-';

            $fullItemName = $productName;
            if (!empty($itemParts)) {
                $fullItemName .= " (" . implode(' | ', $itemParts) . ")";
            }

            $formatedData[] = [
                'no' => $index + 1,
                'invoice' => $data->spk ?? '-',
                'tanggal' => $data->tanggal ? date('d/m/Y', strtotime($data->tanggal)) : '-',
                'waktu' => $data->waktu ? date('H:i', strtotime($data->waktu)) : '-',
                'nama_pelanggan' => strtoupper($data->nama_pelanggan ?? '-'),
                'kontak_pelanggan' => $data->kontak_pelanggan ?? '-',
                'email_pelanggan' => $data->email_pelanggan ?? '-',
                'jenis_cetakan' => $this->getLabelData($data->jenis_cetakan)->name ?? '-',
                'jenis_bahan' => $fullItemName, 
                'panjang' => ($data->panjang !== null) ? ($data->panjang / 100) : '-',
                'lebar' => ($data->lebar !== null) ? ($data->lebar / 100) : '-',
                'jumlah_pesanan' => $data->jumlah_pesanan ?? '-',
                'total_panjang_lebar' => (
                    (empty($data->panjang) ? 1 : ($data->panjang / 100)) *
                    (empty($data->lebar) ? 1 : ($data->lebar / 100))
                ) * ($data->jumlah_pesanan ?? 0),
                'harga' => $data->price ?? '-',
                'total_harga' => $data->subtotal ?? '-',
                'metode_pembayaran' => $this->convertMetodeTransaksi($data->metode_transaksi) ?? '-',
                'total_bayar' => $this->totalSubTotal($data) ?? '-',
                'payment_at' => $data->payment_at ? date('d/m/Y', strtotime($data->payment_at)) : '-',
                'termin' => $data->termin ? $data->termin : '-',
                'status_pembayaran' => $this->getKetPay($data->status_pembayaran) ?? '-',
                'status pengerjaan' => $this->fomatStatusPengerjaan($data->status_pengerjaan) ?? '-',
                'pickup' => $data->pickup ? date('d/m/Y H:i', strtotime($data->pickup)) : '-',
            ];
        }

        return $formatedData;
    }

    private function getProductData($productId)
    {
        $product = Product::find($productId);
        $productData = $product ? $product : '-';

        return $productData;
    }

    public function getLabelData($labelId)
    {
        $label = Label::find($labelId);

        return $label;
    }

   private function getJenisFinishing(?int $intFinishing)
    {   
        if (is_null($intFinishing)) {
            return 'Tanpa Finishing';
        }

        $dataFinishing = [
            0 => 'LPMA',
            1 => 'PGMA',
            2 => 'LOS',
            3 => 'LA',
            4 => 'KOLAB',
            5 => 'KOLKAKI',
            6 => 'KOLAB MA',
            7 => 'KOLKAKI MA',
        ];

        return $dataFinishing[$intFinishing] ?? '-';
    }

    private function getKetPay(?int $intKetPay)
    {   

        $dataKetPay = [
            0 => 'BELUM LUNAS',
            1 => 'DP',
            2 => 'LUNAS',
        ];

        return $dataKetPay[$intKetPay] ?? '-';
    }


    private function fomatStatusPengerjaan($statusPengerjaan)
    {
        $dataStatusPengerjaan = [
            'pending' => 'Pending',
            'verif_pesanan' => 'Verifikasi Pesanan',
            'verif_pembayaran' => 'Verifikasi Pembayaran',
            'produksi' => 'Produksi',
            'pengambilan' => 'Pengambilan',
            'selesai' => 'Selesai',
            'cancel' => 'Batal'
        ];

        return $dataStatusPengerjaan[$statusPengerjaan];
    }

    public function convertInvoiceToSpk($SPKCode, $statusPengerjaan)
    {
        // if ($statusPengerjaan == 'pengambilan' || $statusPengerjaan == 'selesai') {
        //     $code = str_replace('INV', '', $SPKCode);
        //     $finalSPK =  'SPK' . $code;

        //     return $finalSPK;
        // }

        return $SPKCode;
    }

    private function convertMetodeTransaksi(int $intPaymentMethod)
    {
        $dataConvertTrasaction = [
            0 => 'Cash',
            1 => 'Transfer',
            2 => 'QRIS'
        ];

        return $dataConvertTrasaction[$intPaymentMethod] ?? 'TIdak diketahui';

    }

    private function totalSubTotal($order)
    {   
        if ($order->potongan_rp) {
            $totalBayar = $order->subtotal - $order->potongan_rp;
        } else if ($order->diskon_persen) {
            $totalBayar = $order->subtotal - (($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir));
        } else {
            $totalBayar = $order->subtotal;
        }

        return $totalBayar;
    }
}
