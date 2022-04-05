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
        Schema::create('cash_ins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->index('cash_ins_account_id_foreign');
            $table->tinyInteger('transaction_code')->nullable()->default(0);
            $table->unsignedBigInteger('transaction_id')->nullable()->default(0);
            $table->string('name')->nullable();
            $table->string('username', 64)->nullable();
            $table->string('amount', 16);
            $table->string('date', 16);
            $table->text('old_balance');
            $table->text('new_balance');
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
        Schema::dropIfExists('cash_ins');
    }
};
