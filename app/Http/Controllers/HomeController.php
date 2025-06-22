<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
        // Data untuk kemarin
        $yesterday = Carbon::now()->subDay()->toDateString();
        $baseQueryYesterday = Order::query()
            ->where('tanggal', $yesterday)
            ->where('status_pengerjaan', '!=', 'cancel');

        $sumSubTotalOrderYesterday = (clone $baseQueryYesterday)->sum('subtotal');
        $countOrderYesterday = (clone $baseQueryYesterday)->count();

        $sumCashOrderYesterday = (clone $baseQueryYesterday)->where('metode_transaksi', '0')->sum('subtotal');
        $sumTFOrderYesterday = (clone $baseQueryYesterday)->where('metode_transaksi', '1')->sum('subtotal');
        $sumQRISOrderYesterday = (clone $baseQueryYesterday)->where('metode_transaksi', '2')->sum('subtotal');

        $countCashOrderYesterday = (clone $baseQueryYesterday)->where('metode_transaksi', '0')->count();
        $countTFOrderYesterday = (clone $baseQueryYesterday)->where('metode_transaksi', '1')->count();
        $countQRISOrderYesterday = (clone $baseQueryYesterday)->where('metode_transaksi', '2')->count();

        // Data untuk hari ini
        $today = Carbon::now()->toDateString();
        $baseQueryToday = Order::query()
            ->where('tanggal', $today)
            ->where('status_pengerjaan', '!=', 'cancel');

        $sumSubTotalOrderToday = (clone $baseQueryToday)->sum('subtotal');
        $countOrderToday = (clone $baseQueryToday)->count();

        $sumCashOrderToday = (clone $baseQueryToday)->where('metode_transaksi', '0')->sum('subtotal');
        $sumTFOrderToday = (clone $baseQueryToday)->where('metode_transaksi', '1')->sum('subtotal');
        $sumQRISOrderToday = (clone $baseQueryToday)->where('metode_transaksi', '2')->sum('subtotal');

        $countCashOrderToday = (clone $baseQueryToday)->where('metode_transaksi', '0')->count();
        $countTFOrderToday = (clone $baseQueryToday)->where('metode_transaksi', '1')->count();
        $countQRISOrderToday = (clone $baseQueryToday)->where('metode_transaksi', '2')->count();

        // Mengambil 5 order terbaru untuk hari ini
        $orders = (clone $baseQueryToday)->orderBy('deadline', 'desc')->limit(5)->get();

        return view('home', compact(
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
            'l.name',
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
            $query->where('o.tanggal', '>=', $startOfMonth);
            $query->where('o.tanggal', '<=', $endOfMonth);
        }

        $query->groupBy('l.name', DB::raw("DATE_FORMAT(o.tanggal, '%Y-%m')"));

        $results = $query->get();

        return response()->json($results);
    }
}
