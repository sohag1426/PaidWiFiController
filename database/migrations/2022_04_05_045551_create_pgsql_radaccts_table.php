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
        Schema::connection('pgsql')->create('pgsql_radaccts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mgid')->default(0);
            $table->foreignId('operator_id')->default(0);
            $table->string('acctsessionid', 64);
            $table->string('acctuniqueid', 64)->unique();
            $table->string('username', 64);
            $table->string('realm', 64)->nullable();
            $table->string('nasipaddress', 15);
            $table->string('nasportid', 32)->nullable();
            $table->string('nasporttype', 32)->nullable();
            $table->string('nasidentifier')->nullable();
            $table->dateTime('acctstarttime')->nullable();
            $table->dateTime('acctupdatetime')->nullable();
            $table->dateTime('acctstoptime')->nullable();
            $table->integer('acctinterval')->nullable();
            $table->integer('acctsessiontime')->unsigned()->nullable();
            $table->string('acctauthentic', 32)->nullable();
            $table->string('connectinfo_start', 64)->nullable();
            $table->string('connectinfo_stop', 64)->nullable();
            $table->bigInteger('acctinputoctets')->nullable();
            $table->bigInteger('acctoutputoctets')->nullable();
            $table->string('calledstationid', 64);
            $table->string('callingstationid', 64);
            $table->string('acctterminatecause', 32);
            $table->string('servicetype', 32)->nullable();
            $table->string('framedprotocol', 32)->nullable();
            $table->string('framedipaddress', 16);
            $table->string('framedipv6address', 64)->nullable();
            $table->string('framedipv6prefix', 64)->nullable();
            $table->string('framedinterfaceid', 64)->nullable();
            $table->string('delegatedipv6prefix', 64)->nullable();
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
        Schema::dropIfExists('pgsql_radaccts');
    }
};
