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
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mgid')->default(0);
            $table->unsignedBigInteger('gid');
            $table->unsignedBigInteger('operator_id')->index('customer_payments_operator_id_foreign');
            $table->unsignedBigInteger('cash_collector_id')->default(0);
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('customer_bill_id')->default(0);
            $table->unsignedBigInteger('package_id');
            $table->integer('validity_period')->default(0);
            $table->unsignedBigInteger('previous_package_id')->default(0);
            $table->unsignedBigInteger('payment_gateway_id')->nullable();
            $table->string('payment_gateway_name')->nullable();
            $table->string('mobile', 64)->nullable()->default('01700000000');
            $table->string('name')->nullable();
            $table->string('username', 64)->nullable();
            $table->string('type', 16)->default('Cash');
            $table->enum('pay_status', ['Pending', 'Failed', 'Successful'])->default('Pending');
            $table->string('amount_paid', 32)->default('0');
            $table->string('store_amount', 32)->default('0');
            $table->string('transaction_fee', 32)->default('0');
            $table->string('discount', 16)->default('0');
            $table->text('pgw_payment_identifier')->nullable();
            $table->text('mer_txnid');
            $table->text('pgw_txnid')->nullable();
            $table->text('bank_txnid')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_number')->nullable();
            $table->text('payment_token')->nullable();
            $table->string('date', 16);
            $table->string('week', 16);
            $table->string('month', 16);
            $table->string('year', 16);
            $table->tinyInteger('used')->default(0);
            $table->unsignedBigInteger('recharge_card_id')->nullable();
            $table->tinyInteger('require_sms_notice')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_payments');
    }
};
