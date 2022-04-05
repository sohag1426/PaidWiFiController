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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id')->default(0);
            $table->bigInteger('mgid')->default(0);
            $table->unsignedBigInteger('gid');
            $table->unsignedBigInteger('operator_id');
            $table->string('company')->nullable();
            $table->enum('connection_type', ['PPPoE', 'Hotspot', 'StaticIp'])->default('PPPoE');
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable()->default(0);
            $table->string('name')->nullable();
            $table->string('mobile')->nullable()->unique();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('billing_profile_id')->nullable();
            $table->string('username', 64)->nullable()->unique();
            $table->tinyInteger('invalid_username')->default(0);
            $table->string('password', 64)->nullable();
            $table->tinyInteger('sms_password')->default(1);
            $table->tinyInteger('verified_mobile')->default(0);
            $table->string('mobile_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('payment_id')->default(0)->index();
            $table->unsignedBigInteger('package_id')->default(0);
            $table->text('package_name')->nullable();
            $table->text('package_started_at')->nullable();
            $table->text('package_expired_at')->nullable();
            $table->string('rate_limit')->nullable()->default('0');
            $table->string('total_octet_limit')->nullable()->default('0');
            $table->string('advance_payment', 16)->default('0');
            $table->enum('payment_status', ['billed', 'paid'])->default('paid');
            $table->string('last_billing_month', 32)->nullable();
            $table->string('status', 16)->default('active');
            $table->enum('suspend_reason', ['group_admin', 'operator', 'payment_due', 'expiration'])->nullable();
            $table->string('router_ip')->nullable();
            $table->text('link_login_only')->nullable();
            $table->text('link_logout')->nullable();
            $table->string('login_ip', 128)->nullable();
            $table->unsignedBigInteger('package_pool_id')->default(0);
            $table->unsignedBigInteger('fup_pool_id')->default(0);
            $table->unsignedBigInteger('suspended_pool_id')->default(0);
            $table->string('login_mac_address', 64)->default('00:00:00:00:00:00');
            $table->tinyInteger('mac_bind')->default(0);
            $table->integer('otp')->default(0);
            $table->string('session_password', 64)->nullable();
            $table->string('mac_replace_date', 64)->nullable();
            $table->string('house_no')->nullable();
            $table->string('road_no')->nullable();
            $table->string('thana')->nullable();
            $table->string('district')->nullable();
            $table->string('type_of_client')->nullable()->default('Home');
            $table->string('type_of_connection')->nullable()->default('Wired');
            $table->string('type_of_connectivity')->nullable()->default('Shared');
            $table->tinyInteger('texted_locked_status')->default(0);
            $table->string('registration_date', 16)->nullable();
            $table->string('registration_week', 16)->nullable();
            $table->string('registration_month', 16)->nullable();
            $table->string('registration_year', 16)->nullable();
            $table->text('profile_picture')->nullable();
            $table->integer('last_seen_timestamp')->default(0);
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
        Schema::dropIfExists('customers');
    }
};
