<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\operator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (operator::where('role', 'super_admin')->doesntExist()) {
            #create super_admin
            $super_admin = new operator();
            $super_admin->name = 'Super Admin';
            $super_admin->email = config('consumer.super_admin_email');
            $super_admin->email_verified_at = Carbon::now(config('app.timezone'));
            $super_admin->password = Hash::make('w6kMa$Yr2xMd3$rvOdB9');
            $super_admin->company = config('consumer.app_subscriber');
            $super_admin->mobile = config('consumer.super_admin_mobile');
            $super_admin->role = 'super_admin';
            $super_admin->status = 'active';
            $super_admin->subscription_type = 'Free';
            $super_admin->provisioning_status = 2;
            $super_admin->save();
            $super_admin->sid = $super_admin->id;
            $super_admin->mgid = $super_admin->id;
            $super_admin->gid = $super_admin->id;
            $super_admin->save();
        }
    }
}
