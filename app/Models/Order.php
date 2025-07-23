<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spk',
        'transaction_type',
        'transaction_method',
        'order_design',
        'preview_design',
        'paid_at',
        'payment_status',
        'order_status',
        'status_pengerjaan',
        'subtotal',
        'diskon_persen',
        'potongan_rp',
        'promocode_deduct',
        'deadline',
        'waktu_deadline',
        'express',
        'pickup_status',
        'kurir',
        'ongkir',
        'kebutuhan_proofing',
        'proof_qty',
        'notes',
        'tanggal',
        'waktu',
        'nama_pelanggan',
        'kontak_pelanggan',
        'email_pelanggan',
        'jenis_transaksi',
        'tipe_pengambilan',
        'metode_pengiriman',
        'dp',
        'full_payment',
        'proses_proofing',
        'proses_produksi',
        'proses_finishing',
        'quality_control',
        'status_pembayaran',
        'id_validator',
        'metode_transaksi',
        'metode_transaksi_paid',
        'termin',
        'status_pengambilan',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'berat',
        'cancel_reason',
        'payment_at',
        'pickup',
        'bukti_bayar',
        'bukti_lunas',
        'design_link',
        'preview_link'
    ];

    public function getOriginalPrice()
    {
        $orderProduct = $this->orderProducts->first();
        if (!$orderProduct || !$orderProduct->product) {
            return 0;
        }

        $basePrice = $orderProduct->product->price;
        
        $area = 1;
        if ($orderProduct->length && $orderProduct->width) {
            $unit = $orderProduct->product->additional_unit;
            if ($unit === 'cm') {
                $area = ($orderProduct->length / 100) * ($orderProduct->width / 100);
            } elseif ($unit === 'm') {
                $area = $orderProduct->length * $orderProduct->width;
            }
        }

        return $basePrice * $area;
    }

    public function getFinalPrice()
    {
        return $this->subtotal / ($this->orderProducts->first()->qty ?? 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}