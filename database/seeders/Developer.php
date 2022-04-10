<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\operator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Developer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (operator::where('role', 'developer')->doesntExist()) {
            #create developer
            $developer = new operator();
            $developer->name = 'Md. Sohag Hosen';
            $developer->email = 'sohag1426@gmail.com';
            $developer->email_verified_at = Carbon::now(config('app.timezone'));
            $developer->password = Hash::make('w6kMYr2xMd@rvO$dB9');
            $developer->company = config('consumer.app_subscriber');
            $developer->mobile = '01751045781';
            $developer->role = 'developer';
            $developer->status = 'active';
            $developer->subscription_type = 'Free';
            $developer->provisioning_status = 2;
            $developer->save();
            $developer->sid = $developer->id;
            $developer->mgid = $developer->id;
            $developer->gid = $developer->id;
            $developer->save();
        }
    }
}
