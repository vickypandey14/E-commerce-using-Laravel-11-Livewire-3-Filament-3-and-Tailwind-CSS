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
        Schema::table('products', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('in_stock');
            $table->index('on_sale');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index('payment_status');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->index('is_approved');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['in_stock']);
            $table->dropIndex(['on_sale']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['is_approved']);
            $table->dropIndex(['rating']);
        });
    }
};
