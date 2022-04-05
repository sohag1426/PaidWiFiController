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
        Schema::connection('pgsql')->create('pgsql_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mgid');
            $table->foreignId('operator_id');
            $table->foreignId('customer_id');
            $table->string('username', 64)->unique()->nullable();
            $table->string('login_mac_address', 64)->default('00:00:00:00:00:00');
            $table->tinyInteger('mac_bind')->default(0);
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
        Schema::dropIfExists('pgsql_customers');
    }
};
