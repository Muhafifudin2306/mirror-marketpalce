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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id(); 
            $table->string('order_id', 50)->nullable();
            $table->bigInteger('jenis_cetakan')->unsigned()->nullable();
            $table->string('jenis_bahan', 255)->nullable();
            $table->string('jenis_finishing', 255)->nullable();
            $table->double('panjang', 8, 2)->nullable();
            $table->double('lebar', 8, 2)->nullable();
            $table->integer('jumlah_pesanan')->nullable();
            $table->integer('subtotal')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};