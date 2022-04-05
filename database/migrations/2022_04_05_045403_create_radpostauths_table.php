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
        Schema::create('radpostauths', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mgid')->default(0);
            $table->unsignedBigInteger('operator_id')->default(0);
            $table->string('username', 64)->index('radpostauths_username_foreign');
            $table->string('pass', 64);
            $table->string('reply', 32);
            $table->timestamp('authdate', 6)->nullable();
            $table->string('nasipaddress', 16)->nullable();
            $table->string('mac', 64)->nullable();
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
        Schema::dropIfExists('radpostauths');
    }
};
