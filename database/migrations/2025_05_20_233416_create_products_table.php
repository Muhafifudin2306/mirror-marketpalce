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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('label_id');
            $table->string('name', 255)->nullable();
            $table->string('price', 50)->nullable();
            $table->string('additional_size', 50)->nullable();
            $table->string('additional_unit', 255)->nullable();
            $table->string('long_product', 50)->nullable();
            $table->string('width_product', 50)->nullable();
            $table->string('min_qty', 50)->nullable();
            $table->string('max_qty', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
