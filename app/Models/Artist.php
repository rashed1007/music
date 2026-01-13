<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;


class Artist extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;


    protected $fillable = [
        'name',
        'alive'
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


    public function albums()
    {
        return $this->hasMany(Album::class, 'artist_id');
    }


    public function songs()
    {
        return $this->hasMany(Song::class, 'artist_id');
    }
}
