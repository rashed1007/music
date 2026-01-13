<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Song\Store;
use App\Http\Requests\Song\Update;
use App\Http\Resources\Song\Index;
use App\Http\Resources\Song\Show;
use App\Interfaces\SongApiInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class SongController extends Controller
{
    use ApiResponseTrait;

    protected SongApiInterface $songService;

    public function __construct(SongApiInterface $songService)
    {
        $this->songService = $songService;
    }

    public function index(): JsonResponse
    {
        $params = [
            'search' => request()->input('search'),
            'filter' => [
                'artist_id' => request()->input('filter.artist_id'),
                'album_id'  => request()->input('filter.album_id'),
                'year'      => request()->input('filter.year'),
            ],
            'sort' => [
                'created_at' => request()->input('sort.created_at'),
            ],
            'page'     => request()->input('page'),
            'per_page' => request()->input('per_page'),
        ];

        $songs = $this->songService->index($params);

        return $this->apiPaginationResonseForMobile(
            1,
            'success',
            ['songs' => Index::collection($songs)],
            $songs
        );
    }

    public function store(Store $request): JsonResponse
    {
        $song = $this->songService->store($request->validated());

        return $this->apiResonseForMobile(
            1,
            'Song created successfully',
            ['song' => new Show($song)]
        );
    }

    public function show(string $uuid): JsonResponse
    {
        $song = $this->songService->show($uuid);

        return $this->apiResonseForMobile(
            1,
            'success',
            ['song' => new Show($song)]
        );
    }

    public function update(Update $request, string $uuid): JsonResponse
    {
        $song = $this->songService->update($uuid, $request->validated());

        return $this->apiResonseForMobile(
            1,
            'Song updated successfully',
            ['song' => new Show($song)]
        );
    }

    public function destroy(string $uuid): JsonResponse
    {
        $this->songService->delete($uuid);

        return $this->apiResonseForMobile(
            1,
            'Song deleted successfully',
            []
        );
    }
}
