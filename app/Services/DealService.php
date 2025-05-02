<?php

namespace App\Services;

use App\Repositories\DealRepositoryInterface;
use Illuminate\Support\Facades\Log;
use App\Jobs\FetchAndStoreDealsJob;

class DealService
{
    protected DealRepositoryInterface $dealRepository;

    public function __construct(DealRepositoryInterface $dealRepository)
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