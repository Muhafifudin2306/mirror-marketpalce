<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->default(Str::uuid());
            $table->string('name', 255)->nullable();
            $table->unsignedBigInteger('label_id');
            $table->decimal('price', 12, 2)->nullable();
            $table->string('additional_size', 50)->nullable();
            $table->string('additional_unit', 255)->nullable();
            $table->decimal('long_product', 8, 2)->nullable();
            $table->decimal('width_product', 8, 2)->nullable();
            $table->integer('min_qty')->nullable();
            $table->integer('max_qty')->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->decimal('discount_fix', 12, 2)->nullable();
            $table->dateTime('start_discount')->nullable();
            $table->dateTime('end_discount')->nullable();
            $table->string('slug')->unique();
            $table->text('production_time')->nullable();
            $table->text('spesification_desc')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
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
