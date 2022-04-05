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
        Schema::create('all_customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mgid')->default(0);
            $table->unsignedBigInteger('operator_id')->index('all_customers_operator_id_foreign');
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('mobile')->unique();
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
        Schema::dropIfExists('all_customers');
    }
};
