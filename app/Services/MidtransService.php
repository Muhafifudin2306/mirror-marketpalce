<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createSnapToken($order, $user, $deliveryMethod = null, $deliveryCost = 0, $promoCode = '', $promoDiscount = 0)
    {
        $baseSubtotal = $order->orderProducts->sum('subtotal');
        
        $expressFee = 0;
        if ($order->express == 1) {
            $expressFee = $baseSubtotal * 0.5;
        }
        
        $totalBeforeDiscount = $baseSubtotal + $expressFee + $deliveryCost;
        
        $grossAmount = $totalBeforeDiscount - $promoDiscount;
        
        $itemDetails = [];
        
        $itemDetails[] = [
            'id'       => 'subtotal_barang',
            'price'    => (int) $baseSubtotal,
            'quantity' => 1,
            'name'     => 'Subtotal Produk'
        ];
        
        if ($expressFee > 0) {
            $itemDetails[] = [
                'id'       => 'express_fee',
                'price'    => (int) $expressFee,
                'quantity' => 1,
                'name'     => 'Biaya Express (+50%)'
            ];
        }
        
        if ($deliveryCost > 0) {
            $itemDetails[] = [
                'id'       => 'shipping_cost',
                'price'    => (int) $deliveryCost,
                'quantity' => 1,
                'name'     => 'Biaya Pengiriman - ' . ($deliveryMethod ?? 'Kurir')
            ];
        }
        
        if ($promoDiscount > 0) {
            $itemDetails[] = [
                'id'       => 'promo_discount',
                'price'    => -(int) $promoDiscount,
                'quantity' => 1,
                'name'     => 'Diskon Promo: ' . $promoCode
            ];
        }

        $transactionDetails = [
            'order_id'     => $order->id . '-' . time(),
            'gross_amount' => (int) $grossAmount
        ];

        $customerDetails = [
            'first_name'      => $user->first_name,
            'last_name'       => $user->last_name,
            'email'           => $user->email,
            'phone'           => $user->phone,
            'billing_address' => [
                'first_name'  => $user->first_name,
                'last_name'   => $user->last_name,
                'address'     => $user->address,
                'city'        => $user->city,
                'postal_code' => $user->postal_code
            ],
            'shipping_address'=> [
                'first_name'  => $user->first_name,
                'last_name'   => $user->last_name,
                'address'     => $user->address,
                'city'        => $user->city,
                'postal_code' => $user->postal_code
            ]
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'item_details'        => $itemDetails,
            'customer_details'    => $customerDetails,
            'enabled_payments'    => [
                'credit_card','bca_va','bni_va','bri_va','other_va','gopay','shopeepay'
            ]
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat token pembayaran: ' . $e->getMessage());
        }
    }

}