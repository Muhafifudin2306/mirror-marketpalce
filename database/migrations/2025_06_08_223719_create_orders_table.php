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
            $table->string('spk', 100)->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->tinyInteger('transaction_type')->nullable();
            $table->tinyInteger('transaction_method')->nullable()->default(0);  // 0 = Cash, 1 = TF, 2 = QRIS
            $table->text('order_design')->nullable();
            $table->text('preview_design')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->tinyInteger('payment_status')->default(0); // 0 = Belum Lunas / default status
            $table->tinyInteger('order_status')->default(0); // 0 = Pending, 1 = verif_pesanan dll
            $table->integer('subtotal')->default(0);
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->decimal('discount_fix', 12, 2)->nullable();
            $table->decimal('promocode_deduct', 12, 2)->nullable();
            $table->date('deadline_date')->nullable();
            $table->time('deadline_time')->nullable();
            $table->tinyInteger('express')->nullable()->default(0);  // 0 = normal, 1 = express
            $table->string('delivery_method')->nullable();    // e.g. Kurir, Ekspedisi
            $table->integer('delivery_cost')->nullable();
            $table->tinyInteger('needs_proofing')->nullable();   // 0 = tidak perlu, 1 = perlu
            $table->integer('proof_qty')->nullable();
            $table->tinyInteger('pickup_status')->nullable()->default(0);  // 0 = Diambil, 1 = Dikirim
            $table->text('notes')->nullable();
            // $table->tinyInteger('pickup_type')->nullable();     // e.g. Ambil Sendiri, Diantar
            // $table->integer('termin')->default(0);
            // $table->unsignedBigInteger('id_validator')->nullable(); // Auth::id()

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