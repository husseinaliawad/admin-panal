<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('stripe_session_id')->nullable()->after('payment_status');
            $table->string('payment_intent_id')->nullable()->after('stripe_session_id');
            $table->string('customer_email')->nullable()->after('payment_intent_id');
            $table->string('customer_name')->nullable()->after('customer_email');
            $table->json('order_data')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_session_id',
                'payment_intent_id',
                'customer_email',
                'customer_name',
                'order_data'
            ]);
        });
    }
};
