<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DealService;

class FetchDealsCommand extends Command
{
    protected DealService $dealService;

    public function __construct(DealService $dealService)
    {
        parent::__construct();
        $this->dealService = $dealService;
    }

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
        $this->dealService->fetchAndStoreDeals();
        $this->info('Deals fetched successfully.');
    }
}
