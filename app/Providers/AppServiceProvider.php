<?php

namespace App\Providers;

use App\Models\Label;
use App\Models\Order;
use App\Models\Notification;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('landingpage.header', function ($view) {
            // load labels + produk untuk modal di header
            $labels = Label::with('products')->get();
            $view->with('labels', $labels);
        });
        View::composer('*', function ($view) {
            $search = Request::query('search', '');
            $view->with('search', $search);
        });
        View::composer('*', function ($view) {
            // ambil 5 term terbanyak
            $topSearches = SearchHistory::select('term', DB::raw('count(*) as total'))
                ->groupBy('term')
                ->orderByDesc('total')
                ->limit(5)
                ->pluck('term')
                ->toArray();

            $view->with('topSearches', $topSearches);
        });
        // Notifications for authenticated user
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")
                    ->limit(10)
                    ->get();
            } else {
                $notifications = collect();
            }
            $view->with('notifications', $notifications);
        });

        // Orders for profile page
        View::composer('landingpage.profile', function ($view) {
            if (Auth::check()) {
                $orders = Order::with('orderProducts')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $orders = collect();
            }
            $view->with('orders', $orders);
        });

        // keranjang
        View::composer('landingpage.header', function ($view) {
            if (Auth::check()) {
                $orders = Order::with('orderProducts.product.images','orderProducts.product.label')
                    ->where('user_id', Auth::id())
                    ->where('order_status', 0)
                    ->get();
                $items = $orders->pluck('orderProducts')->flatten();
                $view->with('cartItems', $items);
                $view->with('cartCount', $items->count());
            } else {
                $view->with('cartItems', collect());
                $view->with('cartCount', 0);
            }
        });
    }
}
