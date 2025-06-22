<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $query2 = Order::query();
        $yesterday = Carbon::now()->subDay()->toDateString();
       
        $query2->where('tanggal', $yesterday);
        $query2->where('status_pengerjaan', '!=', 'cancel');

        $sumSubTotalOrderYesterday = $query2->sum('subtotal');
        $countOrderYesterday = $query2->count();

        $sumCashOrderYesterday = $query2->where('metode_transaksi', '0')->sum('subtotal');
        $sumTFOrderYesterday = $query2->where('metode_transaksi', '1')->sum('subtotal');
        $sumQRISOrderYesterday = $query2->where('metode_transaksi', '2')->sum('subtotal');

        $countCashOrderYesterday = $query2->where('metode_transaksi', '0')->count();
        $countTFOrderYesterday = $query2->where('metode_transaksi', '1')->count();
        $countQRISOrderYesterday = $query2->where('metode_transaksi', '2')->count();

        $query = Order::query();
        $today = Carbon::now()->toDateString();
        $query->where('tanggal', $today);
        $query->where('status_pengerjaan', '!=', 'cancel');

        $sumSubTotalOrderToday = (clone $query)->sum('subtotal');
        $countOrderToday = (clone $query)->count();

        $sumCashOrderToday = (clone $query)->where('metode_transaksi', '0')->sum('subtotal');
        $sumTFOrderToday = (clone $query)->where('metode_transaksi', '1')->sum('subtotal');
        $sumQRISOrderToday = (clone $query)->where('metode_transaksi', '2')->sum('subtotal');

        $countCashOrderToday = (clone $query)->where('metode_transaksi', '0')->count();
        $countTFOrderToday = (clone $query)->where('metode_transaksi', '1')->count();
        $countQRISOrderToday = (clone $query)->where('metode_transaksi', '2')->count();

        $orders = (clone $query)->orderBy('deadline', 'desc')->limit(5)->get();

        return view('dashboard.index', compact(
            'sumSubTotalOrderToday', 'countOrderToday', 'orders', 'sumCashOrderToday', 'sumTFOrderToday', 'sumQRISOrderToday', 'countCashOrderToday', 'countTFOrderToday', 'countQRISOrderToday',
            'sumSubTotalOrderYesterday', 'countOrderYesterday', 'sumCashOrderYesterday', 'sumTFOrderYesterday', 'sumQRISOrderYesterday', 'countCashOrderYesterday', 'countTFOrderYesterday', 'countQRISOrderYesterday'
        ));
    }

    public function indexJson(Request $request)
    {
        if (!empty($request->period)) {
            $period = Carbon::createFromFormat('Y-m', $request->period);
            $startOfMonth = $period->copy()->startOfMonth();
            $endOfMonth = $period->copy()->endOfMonth();

            $weeklyData = [];
            $start = $startOfMonth->copy();
            $minggu = 1;

            while ($start->lte($endOfMonth)) {
                $end = $start->copy()->addDays(6);
                if ($end->gt($endOfMonth)) {
                    $end = $endOfMonth->copy();
                }

                $sum = Order::where('tanggal', '>=', $start->toDateString())->where('tanggal', '<=', $end->toDateString())->sum('subtotal');

                $weeklyData[] = [
                    'minggu' => "Minggu $minggu",
                    'start' => $start->toDateString(),
                    'end' => $end->toDateString(),
                    'total' => $sum,
                ];

                $start = $end->copy()->addDay();
                $minggu++;
            }

            $totalPerMonth = Order::where('tanggal', '>=', $startOfMonth->toDateString())->where('tanggal', '<=', $endOfMonth->toDateString())->sum('subtotal');

            return response()->json([
                'weekly' => $weeklyData,
                'total_per_month' => $totalPerMonth
            ]);
        }

        return response()->json([]);
    }

    public function getPerMonthPerCategory(Request $request)
    {
        $query = DB::table('orders as o');
        $query->select(
            'p.name',
            'p.additional_size',
            'p.additional_unit',
            'p.long_product', 
            'p.width_product', 
            'l.name AS label_name',
            DB::raw("SUM(op.subtotal) AS op_sub_total"),
            DB::raw("DATE_FORMAT(o.tanggal, '%Y-%m') AS bulan_tahun"),
            DB::raw("COUNT(o.id) AS total_order")
        );

        $query->join('order_products as op', 'o.spk', '=', 'op.order_id');
        $query->join('products as p', 'p.id', '=', 'op.jenis_bahan');
        $query->join('labels as l', 'l.id', '=', 'p.label_id');
        if (!empty($request->period_in_category)) {
            $period = Carbon::createFromFormat('Y-m', $request->period_in_category);
            $startOfMonth = $period->copy()->startOfMonth()->toDateString();
            $endOfMonth = $period->copy()->endOfMonth()->toDateString();
            $query->whereBetween('o.tanggal', [$startOfMonth, $endOfMonth]); 
        }

        $query->groupBy(
            'p.name',
            'p.additional_size',
            'l.name',
            'p.additional_unit',
            'p.long_product',
            'p.width_product',
            DB::raw("DATE_FORMAT(o.tanggal, '%Y-%m')")
        );
        
        $query->orderByDesc('total_order'); 

        $results = $query->get();

        return response()->json($results);
    }
}
