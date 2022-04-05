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
        Schema::create('radchecks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mgid');
            $table->unsignedBigInteger('customer_id');
            $table->string('username', 64)->index();
            $table->string('attribute', 64);
            $table->char('op', 2)->default(':=');
            $table->string('value', 253);
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
        Schema::dropIfExists('radchecks');
    }
};
