<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Album\Store;
use App\Http\Requests\Album\Update;
use App\Http\Resources\Album\Index;
use App\Http\Resources\Album\Show;
use App\Interfaces\AlbumApiInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{
    use ApiResponseTrait;

    protected AlbumApiInterface $albumService;

    public function __construct(AlbumApiInterface $albumService)
    {
        $this->albumService = $albumService;
    }

    public function index(): JsonResponse
    {
        $params = [
            'search' => request()->input('search'),
            'filter' => [
                'artist_id' => request()->input('filter.artist_id'),
                'year'      => request()->input('filter.year'),
            ],
            'sort' => [
                'created_at' => request()->input('sort.created_at'),
            ],
            'page'     => request()->input('page'),
            'per_page' => request()->input('per_page'),
        ];

        $albums = $this->albumService->index($params);

        return $this->apiPaginationResonseForMobile(
            1,
            'success',
            ['albums' => Index::collection($albums)],
            $albums
        );
    }

    public function store(Store $request): JsonResponse
    {
        $album = $this->albumService->store($request->validated());

        return $this->apiResonseForMobile(
            1,
            'Album created successfully',
            ['album' => new Show($album)]
        );
    }

    public function show(string $uuid): JsonResponse
    {
        $album = $this->albumService->show($uuid);

        return $this->apiResonseForMobile(
            1,
            'success',
            ['album' => new Show($album)]
        );
    }

    public function update(Update $request, string $uuid): JsonResponse
    {
        $album = $this->albumService->update($uuid, $request->validated());

        return $this->apiResonseForMobile(
            1,
            'Album updated successfully',
            ['album' => new Show($album)]
        );
    }

    public function destroy(string $uuid): JsonResponse
    {
        $this->albumService->delete($uuid);

        return $this->apiResonseForMobile(
            1,
            'Album deleted successfully',
            []
        );
    }
}
