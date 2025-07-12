<?php

use Illuminate\Support\Facades\DB;
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
        Schema::table('labels', function (Blueprint $table) {
            $table->boolean('is_live')->default(true)->after('unit')->comment('1=live, 0=hidden');
            $table->index('is_live');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_live')->default(true)->after('description')->comment('1=live, 0=hidden');
            $table->index('is_live');
            $table->index(['label_id', 'is_live']);
        });

        DB::table('labels')->whereNull('is_live')->update(['is_live' => true]);
        DB::table('products')->whereNull('is_live')->update(['is_live' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labels', function (Blueprint $table) {
            $table->dropIndex(['is_live']);
            $table->dropColumn('is_live');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_live']);
            $table->dropIndex(['label_id', 'is_live']);
            $table->dropColumn('is_live');
        });
    }
};