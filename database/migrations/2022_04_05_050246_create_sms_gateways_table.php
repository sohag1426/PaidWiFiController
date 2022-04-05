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
        Schema::create('sms_gateways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id')->index('sms_gateways_operator_id_foreign');
            $table->string('provider_name', 64);
            $table->string('username', 64);
            $table->string('password', 64)->nullable();
            $table->string('from_number', 32)->nullable();
            $table->text('post_url')->nullable();
            $table->text('delivery_report_url')->nullable();
            $table->text('balance_check_url')->nullable();
            $table->string('unit_price', 16)->default('0');
            $table->tinyInteger('saleable')->default(0);
            $table->tinyInteger('check_low_balance')->default(0);
            $table->integer('minimum_balance')->default(0);
            $table->string('notification_subscriber')->nullable();
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
        Schema::dropIfExists('sms_gateways');
    }
};
