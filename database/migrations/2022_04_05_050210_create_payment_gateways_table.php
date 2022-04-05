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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id')->index('payment_gateways_operator_id_foreign');
            $table->string('provider_name', 64)->default('easypayway');
            $table->string('send_money_provider', 32)->nullable();
            $table->string('payment_method', 64)->nullable();
            $table->string('username', 64)->nullable();
            $table->string('password', 64)->nullable();
            $table->string('msisdn', 16)->nullable();
            $table->text('credentials_path')->nullable();
            $table->tinyInteger('inheritable')->default(0);
            $table->string('service_charge_percentage', 16)->default('0');
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
        Schema::dropIfExists('payment_gateways');
    }
};
