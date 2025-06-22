<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->time('waktu')->nullable();
            $table->string('spk', 100)->nullable();
            $table->string('nama_pelanggan', 255)->nullable();
            $table->string('kontak_pelanggan', 50)->nullable();
            $table->string('email_pelanggan', 255)->nullable();
            
            $table->tinyInteger('jenis_transaksi')->nullable();      // e.g. Cash, Transfer
            $table->tinyInteger('tipe_pengambilan')->nullable();     // e.g. Ambil Sendiri, Diantar
            $table->tinyInteger('metode_pengiriman')->nullable();    // e.g. Kurir, Ekspedisi

            $table->tinyInteger('kebutuhan_proofing')->nullable();   // 0 = tidak perlu, 1 = perlu
            $table->tinyInteger('express')->nullable()->default(0);  // 0 = normal, 1 = express
            $table->tinyInteger('metode_transaksi')->nullable()->default(0);  // 0 = Cash, 1 = TF, 2 = QRIS
            $table->tinyInteger('status_pengambilan')->nullable()->default(0);  // 0 = Diambil, 1 = Dikirim

            $table->dateTime('deadline')->nullable();
            $table->text('desain')->nullable();

            $table->tinyInteger('proses_proofing')->default(1);
            $table->tinyInteger('proses_produksi')->default(1);
            $table->tinyInteger('proses_finishing')->default(1);
            $table->tinyInteger('quality_control')->default(1);

            $table->string('status_pengerjaan', 100)->default('Pending');
            $table->tinyInteger('status_pembayaran')->default(1); // 1 = Belum Lunas / default status

            $table->integer('subtotal')->default(0);
            $table->integer('termin')->default(0);
            $table->integer('diskon_persen')->default(0);
            $table->integer('potongan_rp')->default(0);
            $table->unsignedBigInteger('id_validator')->nullable(); // Auth::id()

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};