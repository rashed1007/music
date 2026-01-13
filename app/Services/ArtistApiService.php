<?php

namespace App\Services;

use App\Interfaces\ArtistApiInterface;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;

class ArtistApiService implements ArtistApiInterface
{
    public function index(array $params = [])
    {
        $query = Artist::query()
            ->orderByDesc('id');

        // ======== Search ========
        if (!empty($params['search'])) {
            $search = $params['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // ======== Filter ========
        if (!empty($params['filter']['status'])) {
            $query->where('name', $params['filter']['name']);
            $query->where('alive', $params['filter']['alive']);
        }




        // ======== Sort ========
        if (!empty($params['sort'])) {
            foreach ($params['sort'] as $column => $direction) {
                if (
                    in_array(strtolower($direction), ['asc', 'desc']) &&
                    in_array($column, ['created_at'])
                ) {
                    $query->orderBy($column, $direction);
                }
            }
        }

        // ======== Pagination ========
        $page    = $params['page'] ?? 1;
        $perPage = $params['per_page'] ?? 10;

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {


            $artist = Artist::create($data);

            // ===== Image Upload (REQUIRED) =====
            $artist->addMedia($data['image'])
                ->toMediaCollection('artist');

            return $artist;
        });
    }

    public function show(string $uuid)
    {
        return Artist::where('uuid', $uuid)
            ->firstOrFail();
    }

    public function update(string $uuid, array $data)
    {
        return DB::transaction(function () use ($uuid, $data) {

            $artist = Artist::where('uuid', $uuid)
                ->firstOrFail();

            $artist->update($data);

            // ===== Image Update =====
            if (!empty($data['image'])) {
                $artist->clearMediaCollection('artist');
                $artist->addMedia($data['image'])
                    ->toMediaCollection('artist');
            }

            return $artist;
        });
    }

    public function delete(string $uuid)
    {
        $artist = Artist::where('uuid', $uuid)
            ->firstOrFail();

        $artist->clearMediaCollection('artist');

        return $artist->delete();
    }
}
