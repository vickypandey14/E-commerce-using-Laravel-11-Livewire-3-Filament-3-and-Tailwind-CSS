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
        // 1. Payment Gateways Table
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('driver');
            $table->boolean('is_active')->default(false);
            $table->string('environment')->default('sandbox'); // sandbox, live
            $table->integer('priority')->default(0);
            $table->boolean('is_default')->default(false);
            $table->longText('credentials')->nullable(); // Cast encrypted:array in model
            $table->text('settings')->nullable(); // JSON configuration options
            $table->string('health_status')->default('unknown'); // healthy, degraded, down, unknown
            $table->timestamp('last_health_check_at')->nullable();
            $table->timestamps();
        });

        // 2. Payment Transactions (Audit Logs)
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('gateway_code');
            $table->string('gateway_transaction_id')->nullable()->index();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('INR');
            $table->string('status')->default('pending'); // pending, completed, failed, refunded, partially_refunded, disputed, expired
            $table->string('type')->default('payment'); // payment, refund, payout
            $table->text('error_message')->nullable();
            $table->longText('payload')->nullable(); // JSON history/response trace
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // 3. Payment Refunds
        Schema::create('payment_refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('order_id');
            $table->string('gateway_refund_id')->nullable()->index();
            $table->decimal('amount', 15, 2);
            $table->string('reason')->nullable();
            $table->string('status')->default('pending'); // pending, processed, failed
            $table->text('metadata')->nullable(); // JSON payload details
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('payment_transactions')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        // 4. Payment Disputes
        Schema::create('payment_disputes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('order_id');
            $table->string('gateway_dispute_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('INR');
            $table->string('reason')->nullable();
            $table->string('status')->default('opened'); // opened, under_review, won, lost
            $table->text('evidence')->nullable(); // JSON timeline / upload trace
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('payment_transactions')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        // 5. Payment Payouts
        Schema::create('payment_payouts', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_code');
            $table->string('gateway_payout_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('INR');
            $table->string('status')->default('pending'); // pending, sent, failed, cancelled
            $table->timestamp('arrival_date')->nullable();
            $table->text('metadata')->nullable(); // JSON summary details
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_payouts');
        Schema::dropIfExists('payment_disputes');
        Schema::dropIfExists('payment_refunds');
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('payment_gateways');
    }
};
