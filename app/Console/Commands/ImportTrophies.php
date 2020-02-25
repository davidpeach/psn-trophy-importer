<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Trophies\TrophiesConnection;

class ImportTrophies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psn:trophies:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import trophies from PSN';

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
    public function handle(TrophiesConnection $trophies)
    {
        $trophies->import();
    }
}
