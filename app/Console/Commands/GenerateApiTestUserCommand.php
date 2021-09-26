<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApiTestUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api_test_user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an API test user';

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
     * @return mixed
     */
    public function handle()
    {
        $user = new User;
        $user->first_name = "Test";
        $user->last_name = "User";
        $user->email = $this->argument('email');
        $user->password = Str::random(16);

        $user->save();

        $this->info($user->generateApiToken());
    }
}
