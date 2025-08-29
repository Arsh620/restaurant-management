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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->index(['cuisine']);
            $table->index(['location']);
            $table->index(['name']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index(['restaurant_id']);
            $table->index(['order_time']);
            $table->index(['order_amount']);
            $table->index(['restaurant_id', 'order_time']);
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropIndex(['cuisine']);
            $table->dropIndex(['location']);
            $table->dropIndex(['name']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['restaurant_id']);
            $table->dropIndex(['order_time']);
            $table->dropIndex(['order_amount']);
            $table->dropIndex(['restaurant_id', 'order_time']);
        });
    }
};
