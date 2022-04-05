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
        Schema::create('master_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id')->default(0);
            $table->unsignedBigInteger('mgid');
            $table->unsignedBigInteger('pppoe_profile_id')->nullable();
            $table->enum('connection_type', ['PPPoE', 'Hotspot', 'StaticIp'])->default('PPPoE');
            $table->text('name');
            $table->integer('rate_limit')->default(0);
            $table->enum('rate_unit', ['M', 'k'])->default('M');
            $table->enum('speed_controller', ['Router', 'Radius_Server'])->default('Router');
            $table->integer('volume_limit')->default(0);
            $table->enum('volume_unit', ['GB', 'MB'])->default('MB');
            $table->integer('validity')->default(30);
            $table->integer('price')->default(0);
            $table->integer('operator_price')->default(0);
            $table->enum('visibility', ['public', 'private'])->default('private');
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
        Schema::dropIfExists('master_packages');
    }
};
