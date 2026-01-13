<?php

namespace App\Services;

use App\Interfaces\SongApiInterface;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;

class SongApiService implements SongApiInterface
{
    public function index(array $params = [])
    {
        $query = Song::query()->orderByDesc('id');

        // ======== Search ========
        if (!empty($params['search'])) {
            $search = $params['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('album_name', 'like', "%{$search}%")
                    ->orWhere('artist_name', 'like', "%{$search}%")
                    ->orWhere('year', 'like', "%{$search}%");
            });
        }

        // ======== Filter ========
        if (!empty($params['filter']['artist_id'])) {
            $query->where('artist_id', $params['filter']['artist_id']);
        }

        if (!empty($params['filter']['album_id'])) {
            $query->where('album_id', $params['filter']['album_id']);
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

            $album  = Album::findOrFail($data['album_id']);
            $artist = Artist::findOrFail($data['artist_id']);

            $song = Song::create([
                'album_id'   => $album->id,
                'album_name' => $album->name,
                'artist_id'  => $artist->id,
                'artist_name' => $artist->name,
                'name'       => $data['name'],
                'year'       => $data['year'],
            ]);

            // ===== Media Upload (optional) =====
            if (!empty($data['file'])) {
                $song->addMedia($data['file'])
                    ->toMediaCollection('song');
            }

            return $song;
        });
    }

    public function show(string $uuid)
    {
        return Song::where('uuid', $uuid)->firstOrFail();
    }

    public function update(string $uuid, array $data)
    {
        return DB::transaction(function () use ($uuid, $data) {

            $song = Song::where('uuid', $uuid)->firstOrFail();

            if (!empty($data['album_id'])) {
                $album = Album::findOrFail($data['album_id']);
                $data['album_name'] = $album->name;
            }

            if (!empty($data['artist_id'])) {
                $artist = Artist::findOrFail($data['artist_id']);
                $data['artist_name'] = $artist->name;
            }

            $song->update($data);

            // ===== Media Update =====
            if (!empty($data['file'])) {
                $song->clearMediaCollection('song');
                $song->addMedia($data['file'])
                    ->toMediaCollection('song');
            }

            return $song;
        });
    }

    public function delete(string $uuid)
    {
        $song = Song::where('uuid', $uuid)->firstOrFail();

        $song->clearMediaCollection('song');

        return $song->delete();
    }
}
