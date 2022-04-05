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
        Schema::create('card_distributors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id')->default(0);
            $table->unsignedBigInteger('operator_id')->index('card_distributors_operator_id_foreign');
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('commission')->nullable();
            $table->string('amount_due', 64)->default('0');
            $table->string('store_name')->nullable();
            $table->longText('store_address')->nullable();
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
        Schema::dropIfExists('card_distributors');
    }
};
