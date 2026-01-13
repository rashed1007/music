<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Artist\Store;
use App\Http\Requests\Artist\Update;
use App\Http\Resources\Artist\Index;
use App\Http\Resources\Artist\Show;
use App\Interfaces\ArtistApiInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ArtistController extends Controller
{
    use ApiResponseTrait;

    protected ArtistApiInterface $artistService;

    public function __construct(ArtistApiInterface $artistService)
    {
        $this->artistService = $artistService;
    }

    public function index(): JsonResponse
    {
        $params = [
            'search' => request()->input('search'),
            'filter' => [
                'alive'     => request()->input('filter.alive'),
                'name'  => request()->input('filter.name'),
            ],
            'sort' => [
                'created_at' => request()->input('sort.created_at'),
            ],
            'page'     => request()->input('page'),
            'per_page' => request()->input('per_page'),
        ];

        $artists = $this->artistService->index($params);

        return $this->apiPaginationResonseForMobile(
            1,
            'success',
            ['artists' => Index::collection($artists)],
            $artists
        );
    }

    public function store(Store $request): JsonResponse
    {
        $artist = $this->artistService->store($request->validated());

        return $this->apiResonseForMobile(
            1,
            'Artist created successfully',
            ['artist' => new Show($artist)]
        );
    }

    public function show(string $uuid): JsonResponse
    {
        $artist = $this->artistService->show($uuid);

        return $this->apiResonseForMobile(
            1,
            'success',
            ['artist' => new Show($artist)]
        );
    }

    public function update(Update $request, string $uuid): JsonResponse
    {
        $artist = $this->artistService->update($uuid, $request->validated());

        return $this->apiResonseForMobile(
            1,
            'Artist updated successfully',
            ['artist' => new Show($artist)]
        );
    }

    public function destroy(string $uuid): JsonResponse
    {
        $this->artistService->delete($uuid);

        return $this->apiResonseForMobile(
            1,
            'Artist deleted successfully',
            []
        );
    }
}
