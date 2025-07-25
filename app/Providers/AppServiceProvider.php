<?php

namespace App\Providers;

use App\Models\Chat;
use App\Models\Label;
use App\Models\Order;
use App\Models\Notification;
use App\Models\OrderProduct;
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
            $labels = Label::with('products')->get();
            $view->with('labels', $labels);
        });
        View::composer('*', function ($view) {
            $search = Request::query('search', '');
            $view->with('search', $search);
        });
        View::composer('*', function ($view) {
            $topSearches = SearchHistory::select('term', DB::raw('count(*) as total'))
                ->groupBy('term')
                ->orderByDesc('total')
                ->limit(5)
                ->pluck('term')
                ->toArray();

            $view->with('topSearches', $topSearches);
        });
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::where(function($q) {
                        $q->where('user_id', Auth::id())
                        ->orWhereNull('user_id');
                    })
                    ->orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")
                    ->limit(10)
                    ->get();
            } else {
                $notifications = collect();
            }
            $view->with('notifications', $notifications);
        });

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

        
        View::composer('*', function ($view) {
            $relevantChats = collect();

            if (Auth::check()) {
                $user = Auth::user();

                if ($user->role === 'Admin') {
                    $relevantChats = Chat::where('chat_status', 0) 
                                        ->orderBy('updated_at', 'desc')
                                        ->where('channel','chat')
                                        ->limit(10)
                                        ->get();
                } elseif ($user->role === 'Customer') {
                    $relevantChats = Chat::where('user_id', $user->id)
                                        ->where('chat_status', 0)
                                        ->where('channel','reply')
                                        ->orderBy('updated_at', 'desc')
                                        ->limit(10)
                                        ->get();
                }
            }

            $view->with('chats', $relevantChats);
        });

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
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $cartItems = OrderProduct::with([
                    'product.images',
                    'product.discounts' => function($q) {
                        $q->where('start_discount', '<=', now())
                        ->where('end_discount', '>=', now());
                    },
                    'order'
                ])
                ->whereHas('order', function($q) {
                    $q->where('user_id', Auth::id())
                    ->where('order_status', 0);
                })
                ->get();

                $cartCount = $cartItems->count();
                
                // ✅ GUNAKAN SUBTOTAL DARI DATABASE (sudah termasuk finishing + varian)
                $subtotal = $cartItems->sum('subtotal');

                $view->with(compact('cartItems', 'cartCount', 'subtotal'));
            }
        });
    }
}
