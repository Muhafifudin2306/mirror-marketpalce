<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'waktu',
        'spk',
        'nama_pelanggan',
        'kontak_pelanggan',
        'email_pelanggan',
        'jenis_transaksi',
        'tipe_pengambilan',
        'metode_pengiriman',
        'kebutuhan_proofing',
        'express',
        'deadline',
        'dp',
        'full_payment',
        'waktu_deadline',
        'proses_proofing',
        'proses_produksi',
        'proses_finishing',
        'quality_control',
        'status_pengerjaan',
        'status_pembayaran',
        'subtotal',
        'id_validator',
        'metode_transaksi',
        'termin',
        'status_pengambilan',
        'diskon_persen',
        'potongan_rp',
        'ongkir',
        'kurir',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'berat',
        'cancel_reason',
        'payment_at',
        'payment_status',
        'pickup',
        'bukti_bayar',
        'bukti_lunas',
        'paid_at'
    ];
}
