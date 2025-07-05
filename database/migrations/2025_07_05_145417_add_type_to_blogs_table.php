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
        Schema::table('blogs', function (Blueprint $table) {
            $table->enum('blog_type', ['Promo Sinau', 'Printips', 'Company', 'Printutor'])->default('Printips');
            $table->tinyInteger('is_live')->default(1);
        });
    }
};