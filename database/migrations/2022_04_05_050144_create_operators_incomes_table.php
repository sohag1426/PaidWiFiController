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
        Schema::create('operators_incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id')->index('operators_incomes_operator_id_foreign');
            $table->unsignedBigInteger('payment_id');
            $table->enum('source', ['customers_payment', 'subscription_fee'])->default('customers_payment');
            $table->string('amount');
            $table->string('date', 16);
            $table->string('week', 16);
            $table->string('month', 16);
            $table->string('year', 16);
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
        Schema::dropIfExists('operators_incomes');
    }
};
