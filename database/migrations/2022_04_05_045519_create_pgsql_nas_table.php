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
        Schema::connection('pgsql')->create('pgsql_nas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mgid');
            $table->text('location')->nullable();
            $table->string('nasname', 128);
            $table->string('shortname', 32)->nullable();
            $table->string('type', 32)->default('mikrotik_snmp');
            $table->integer('ports')->nullable();
            $table->string('secret', 64);
            $table->string('server', 64)->nullable();
            $table->string('community', 64)->default('billing');
            $table->string('description', 128)->default('RADIUS Client');
            $table->integer('api_port')->nullable();
            $table->integer('telnet_port')->nullable();
            $table->string('api_username', 64)->nullable();
            $table->text('api_password')->nullable();
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
        Schema::dropIfExists('pgsql_nas');
    }
};
