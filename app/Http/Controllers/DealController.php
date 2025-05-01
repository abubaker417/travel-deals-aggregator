<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DealService;
use App\Repositories\DealRepository;

class DealController extends Controller
{
    protected DealService $dealService;
    protected DealRepository $dealRepository;

    public function __construct(DealService $dealService, DealRepository $dealRepository)
    {
        $this->dealService = $dealService;
        $this->dealRepository = $dealRepository;
    }

    public function index()
    {
        $deals = $this->dealRepository->getAll();
        return response()->json(['deals' => $deals]);
    }

    public function show(int $id)
    {
        $deal = $this->dealRepository->find($id);
        return response()->json(['deal' => $deal ?: []], $deal ? 200 : 404);
    }

    public function bookmark(int $id)
    {
        $userId = auth()->id();
        $result = $this->dealService->bookmarkDeal($id, $userId);

        return response()->json([
            'message' => $result['message'],
        ], $result['success'] ? 200 : ($result['message'] === 'Deal not found' ? 404 : 400));
    }

    public function userBookmarks()
    {
        $bookmarks = $this->dealRepository->getUserBookmarks(auth()->id());
        return response()->json(['bookmarks' => $bookmarks]);
    }
}
