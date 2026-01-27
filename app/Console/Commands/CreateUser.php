<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create user';

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
     * @throws \Throwable
     */
    public function handle()
    {
        $username = $this->argument('username');
        $password = $this->argument('password');

        try {

            $model = new User([
                                  'username' => $username,
                                  'name'     => $username,
                                  'password' => Hash::make($password),
                              ]);

            $model->save();

            echo 'success';
            return CommandAlias::SUCCESS;
        } catch (QueryException $e) {

        }
        return CommandAlias::FAILURE;
    }
}
