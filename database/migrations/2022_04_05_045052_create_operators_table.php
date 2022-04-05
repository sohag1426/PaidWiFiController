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
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id')->default(0);
            $table->unsignedBigInteger('sid')->nullable();
            $table->unsignedBigInteger('mgid')->default(0);
            $table->unsignedBigInteger('gid')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('company')->nullable();
            $table->string('company_logo', 128)->nullable();
            $table->string('radius_db_connection', 64)->default('mysql');
            $table->string('mobile', 32)->nullable();
            $table->string('mobile_verified_at', 64)->nullable();
            $table->tinyInteger('two_factor_activated')->default(0);
            $table->tinyInteger('two_factor_challenge_due')->default(0);
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->enum('role', ['super_admin', 'group_admin', 'operator', 'sub_operator', 'manager', 'card_distributor', 'sales_manager', 'developer', 'accountant'])->default('group_admin');
            $table->enum('status', ['active', 'disabled', 'suspended'])->default('active');
            $table->enum('subscription_type', ['Paid', 'Free'])->default('Paid');
            $table->enum('subscription_status', ['active', 'suspended'])->default('active');
            $table->string('photo', 128)->default('unknow_man.png');
            $table->string('birth_date')->nullable();
            $table->string('house_no')->nullable();
            $table->string('road_no')->nullable();
            $table->string('thana')->nullable();
            $table->string('district')->nullable();
            $table->string('postal_code', 16)->nullable();
            $table->tinyInteger('provisioning_status')->default(0);
            $table->tinyInteger('using_payment_gateway')->default(0);
            $table->enum('account_type', ['credit', 'debit'])->default('credit');
            $table->string('credit_limit')->default('0');
            $table->string('sp_key')->nullable();
            $table->string('sd_key')->nullable();
            $table->tinyInteger('sp_request')->default(0);
            $table->tinyInteger('sd_request')->default(0);
            $table->integer('mrk_email_count')->default(0);
            $table->integer('exam_attendance')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('operators');
    }
};
