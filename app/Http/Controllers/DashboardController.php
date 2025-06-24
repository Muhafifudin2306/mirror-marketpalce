<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User; //panggil model
use App\Models\Pesanan; //panggil model

class DashboardController extends Controller
{
    public function index()
    {
        // 1) Total pendapatan: jumlahkan subtotal order yang sudah "Done"
        $totalIncome = Order::where('order_status', 2)
                            ->sum('subtotal');

        // 2) Total produk terjual: jumlahkan qty di order_products
        $totalProdukTerjual = OrderProduct::join('orders', 'order_products.order_id', '=', 'orders.id')
                            ->where('orders.order_status', 2)
                            ->sum('order_products.qty');

        // 3) Total pelanggan: hitung user dengan role "Customer"
        $totalPelanggan = User::where('role', 'Customer')->count();

        // 4) Grafik pendapatan per bulan (6 bulan terakhir)
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        // 4) Grafik pendapatan per bulan (6 bulan terakhir), pakai $months
        $dataIncome = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(subtotal) as income")
                        ->where('order_status', 2)
                        ->whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), [$months->first(), $months->last()])
                        ->groupBy('month')
                        ->pluck('income', 'month');

        $bulanIncome = $months->map(function($m) use ($dataIncome) {
            return [
                'month'  => $m,
                'income' => $dataIncome->get($m, 0)
            ];
        });

        // 5) Grafik produk terjual per bulan (6 bulan terakhir), pakai $months
        $dataTerjual = OrderProduct::selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m') as month, SUM(qty) as terjual")
                        ->join('orders','order_products.order_id','=','orders.id')
                        ->where('orders.order_status', 2)
                        ->whereBetween(DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m')"), [$months->first(), $months->last()])
                        ->groupBy('month')
                        ->pluck('terjual','month');

        $bulanTerjual = $months->map(function($m) use ($dataTerjual) {
            return [
                'month'   => $m,
                'terjual' => $dataTerjual->get($m, 0)
            ];
        });


        return view('adminpage.home', compact(
            'totalIncome',
            'totalProdukTerjual',
            'totalPelanggan',
            'bulanIncome',
            'bulanTerjual'
        ));
    }

}