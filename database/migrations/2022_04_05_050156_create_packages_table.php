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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id')->default(0);
            $table->unsignedBigInteger('mgid')->default(0);
            $table->unsignedBigInteger('gid')->default(0);
            $table->unsignedBigInteger('operator_id')->default(0)->index('packages_operator_id_foreign');
            $table->unsignedBigInteger('mpid')->default(0)->index('packages_mpid_foreign');
            $table->unsignedBigInteger('ppid')->default(0);
            $table->text('name');
            $table->integer('price')->default(0);
            $table->string('operator_price')->default('0');
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
        Schema::dropIfExists('packages');
    }
};
