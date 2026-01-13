<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;


class Song extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;


    protected $fillable = [
        'album_id',
        'album_name',
        'artist_id',
        'artist_name',
        'year',
        'name',
    ];




    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }


    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
