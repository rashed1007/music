<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;

class MusicSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {

            /** -----------------
             *  Create Artist
             *  -----------------
             */
            $artist = Artist::create([
                'uuid'  => Str::uuid(),
                'name'  => "Artist {$i}",
                'alive' => true,
            ]);

            /** -----------------
             *  Create Album
             *  -----------------
             */
            $album = Album::create([
                'uuid'        => Str::uuid(),
                'artist_id'   => $artist->id,
                'artist_name' => $artist->name,
                'name'        => "Album {$i}",
                'year'        => rand(1990, 2025),
            ]);

            /** -----------------
             *  Create Song
             *  -----------------
             */
            Song::create([
                'uuid'        => Str::uuid(),
                'album_id'    => $album->id,
                'album_name'  => $album->name,
                'artist_id'   => $artist->id,
                'artist_name' => $artist->name,
                'name'        => "Song {$i}",
                'year'        => $album->year,
            ]);
        }
    }
}
