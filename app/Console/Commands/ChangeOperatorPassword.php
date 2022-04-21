<?php

namespace App\Console\Commands;

use App\Models\operator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangeOperatorPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change_operator_password {operator_id}  {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Operator Password';

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
        $operator_id = $this->argument('operator_id');

        $password = $this->argument('password');

        $operator = operator::findOrFail($operator_id);

        $this->info("Name: " . $operator->name . " Role: " . $operator->role . " Email: " . $operator->email);

        if ($this->confirm('Do you wish to continue?') == false) {
            return 0;
        }

        $operator->password = Hash::make($password);
        $operator->save();

        $this->info('Password has been changed successfully!');
        return 0;
    }
}
