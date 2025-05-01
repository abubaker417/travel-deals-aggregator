<?php

namespace App\Repositories;

use App\Models\Deal;

class DealRepository
{
    public function create(array $data): Deal
    {
        return Deal::create($data);
    }

    public function find(int $id): ?Deal
    {
        return Deal::find($id);
    }

    public function getAll(int $limit = 1000)
    {
        return Deal::query()->take($limit)->get();
    }

    public function hasBookmark(int $dealId, int $userId): bool
    {
        return Deal::where('id', $dealId)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->exists();
    }

    public function bookmark(int $dealId, int $userId): array
    {
        $deal = $this->find($dealId);
        if (!$deal) {
            return ['success' => false, 'message' => 'Deal not found'];
        }

        if ($this->hasBookmark($dealId, $userId)) {
            return ['success' => false, 'message' => 'You have already bookmarked this deal'];
        }

        $deal->users()->attach($userId);
        return ['success' => true, 'message' => 'Deal bookmarked'];
    }

    public function getUserBookmarks(int $userId)
    {
        return Deal::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }
}