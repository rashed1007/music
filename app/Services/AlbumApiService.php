<?php

namespace App\Services;

use App\Interfaces\AlbumApiInterface;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;

class AlbumApiService implements AlbumApiInterface
{
    public function index(array $params = [])
    {
        $query = Album::query()->orderByDesc('id');

        // ======== Search ========
        if (!empty($params['search'])) {
            $search = $params['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('artist_name', 'like', "%{$search}%")
                    ->orWhere('year', 'like', "%{$search}%");
            });
        }

        // ======== Filter ========
        if (!empty($params['filter']['artist_id'])) {
            $query->where('artist_id', $params['filter']['artist_id']);
        }

        if (!empty($params['filter']['year'])) {
            $query->where('year', $params['filter']['year']);
        }

        // ======== Sort ========
        if (!empty($params['sort'])) {
            foreach ($params['sort'] as $column => $direction) {
                if (
                    in_array(strtolower($direction), ['asc', 'desc']) &&
                    in_array($column, ['created_at', 'year'])
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

            $artist = Artist::findOrFail($data['artist_id']);

            $album = Album::create([
                'artist_id'   => $artist->id,
                'artist_name' => $artist->name,
                'name'        => $data['name'],
                'year'        => $data['year'],
            ]);

            // ===== Image Upload =====
            if (!empty($data['image'])) {
                $album->addMedia($data['image'])
                    ->toMediaCollection('album');
            }

            return $album;
        });
    }

    public function show(string $uuid)
    {
        return Album::where('uuid', $uuid)->firstOrFail();
    }

    public function update(string $uuid, array $data)
    {
        return DB::transaction(function () use ($uuid, $data) {

            $album = Album::where('uuid', $uuid)->firstOrFail();

            if (!empty($data['artist_id'])) {
                $artist = Artist::findOrFail($data['artist_id']);
                $data['artist_name'] = $artist->name;
            }

            $album->update($data);

            // ===== Image Update =====
            if (!empty($data['image'])) {
                $album->clearMediaCollection('album');
                $album->addMedia($data['image'])
                    ->toMediaCollection('album');
            }

            return $album;
        });
    }

    public function delete(string $uuid)
    {
        $album = Album::where('uuid', $uuid)->firstOrFail();

        $album->clearMediaCollection('album');

        return $album->delete();
    }
}
