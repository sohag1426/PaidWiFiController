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
        Schema::create('recharge_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id')->index('recharge_cards_operator_id_foreign');
            $table->unsignedBigInteger('card_distributor_id')->default(0);
            $table->unsignedBigInteger('package_id')->index('recharge_cards_package_id_foreign');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('mobile', 32)->default('0');
            $table->enum('status', ['used', 'unused'])->default('unused');
            $table->string('pin');
            $table->string('creation_date', 16)->nullable();
            $table->string('creation_month', 16)->nullable();
            $table->string('creation_year', 16)->nullable();
            $table->string('used_date', 16)->nullable();
            $table->string('used_month', 16)->nullable();
            $table->string('used_year', 16)->nullable();
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
        Schema::dropIfExists('recharge_cards');
    }
};
