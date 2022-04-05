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
        Schema::create('sms_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id')->nullable()->index('sms_histories_operator_id_foreign');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('sms_gateway_id')->nullable();
            $table->unsignedBigInteger('sms_bill_id')->default(0);
            $table->text('messageid')->nullable();
            $table->string('from_number', 32)->nullable();
            $table->string('to_number', 16)->nullable();
            $table->string('status_code', 8)->nullable();
            $table->enum('status_text', ['Pending', 'Failed', 'Successful'])->default('Pending');
            $table->text('status_details')->nullable();
            $table->string('sms_count', 8)->nullable();
            $table->string('sms_cost', 8)->nullable();
            $table->text('sms_body')->nullable();
            $table->tinyInteger('cost_checked')->default(0);
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
        Schema::dropIfExists('sms_histories');
    }
};
