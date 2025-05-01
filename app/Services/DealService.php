<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class DealService
{
    public function fetchAndStoreDeals(): void
    {
        try {
            Log::info('FetchAndStoreDealsJob');
        } catch (\Exception $e) {
            Log::error('Error dispatching FetchAndStoreDealsJob: ' . $e->getMessage());
        }
    }
}