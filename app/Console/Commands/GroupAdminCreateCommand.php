<?php

namespace App\Console\Commands;

use App\Http\Controllers\DatabaseConnectionAssignController;
use App\Models\operator;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GroupAdminCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:group_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create group admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //getting info
        $super_admin = operator::where('role', 'super_admin')->first();
        $sid = $super_admin->id;
        $name = $this->ask("What is the name?");
        $email = $this->ask("Email address?");
        $password =  $this->secret('What is the password?');
        $company = $this->ask("what is compay name?");
        $mobile = $this->ask("Mobile Number?");

        // creating admin
        $group_admin = new operator();
        $group_admin->sid = $sid;
        $group_admin->name = $name;
        $group_admin->email = $email;
        $group_admin->email_verified_at = Carbon::now(config('app.timezone'));
        $group_admin->password = Hash::make($password);
        $group_admin->company = $company;
        $group_admin->radius_db_connection = DatabaseConnectionAssignController::assignDatabaseConnection();
        $group_admin->mobile = $mobile;
        $group_admin->helpline = $mobile;
        $group_admin->role = "group_admin";
        $group_admin->subscription_type = "Free";
        $group_admin->provisioning_status = 2;
        $group_admin->save();
        $group_admin->mgid = $group_admin->id;
        $group_admin->gid = $group_admin->id;
        $group_admin->save();

        $this->info("Group Admin has been created successfully!");
        $this->info("Email: " . $email);
        $this->info("Password: " . $password);
        return 0;
    }
}
