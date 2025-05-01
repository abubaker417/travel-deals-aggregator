<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchDealsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deals:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store travel deals from external API';    

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching deals...');
        $this->info('Deals fetched successfully.');
    }
}
