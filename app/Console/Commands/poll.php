<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\puntoController;

class poll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do request to get updates for telegram';

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
        // $client = new \GuzzleHttp\Client();
        // $res = $client->get('https://api.hikaro.space/punto'); 
        puntoController::punto();
    }
}
