<?php

namespace App\Console\Commands;

use App\Trophies\Auth;
use Illuminate\Console\Command;

class PsnFirstLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psn:login {token : The NPSSO code from the manual login. See https://tusticles.com/psn-php/first_login.html}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial login for PSN using a manually generated NPSSO code. See https://tusticles.com/psn-php/first_login.html';

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
    public function handle(Auth $auth)
    {
        try {
            $auth->firstLogin($this->argument('token'));
            $this->info('Sucessfully logged in to PSN');
        } catch (\Exception $e) {
            $this->error('Error trying to log in to PSN');
        }
    }
}
