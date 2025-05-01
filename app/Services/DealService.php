<?php

namespace App\Services;

use App\Repositories\DealRepository;
use Illuminate\Support\Facades\Log;
use App\Jobs\FetchAndStoreDealsJob;

class DealService
{
    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function fetchAndStoreDeals(): void
    {
        try {
            FetchAndStoreDealsJob::dispatch($this->dealRepository);
            Log::info('FetchAndStoreDealsJob dispatched');
        } catch (\Exception $e) {
            Log::error('Error dispatching FetchAndStoreDealsJob: ' . $e->getMessage());
        }
    }

    public function bookmarkDeal(int $dealId, int $userId): array
    {
        return $this->dealRepository->bookmark($dealId, $userId);
    }
}