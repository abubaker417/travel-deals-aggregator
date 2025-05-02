<?php

namespace App\Repositories;

interface DealRepositoryInterface {
    public function create(array $data): \App\Models\Deal;
    public function find(int $id): ?\App\Models\Deal;
    public function getAll(int $limit = 1000);
    public function hasBookmark(int $dealId, int $userId): bool;
    public function bookmark(int $dealId, int $userId): array;
    public function getUserBookmarks(int $userId);
}