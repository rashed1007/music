<?php

namespace App\Providers;

use App\Interfaces\AlbumApiInterface;
use App\Interfaces\ArtistApiInterface;
use App\Interfaces\AuthApiInterface;
use App\Interfaces\SongApiInterface;
use App\Services\AlbumApiService;
use App\Services\ArtistApiService;
use App\Services\AuthApiService;
use App\Services\SongApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthApiInterface::class, AuthApiService::class);
        $this->app->bind(ArtistApiInterface::class, ArtistApiService::class);
        $this->app->bind(AlbumApiInterface::class, AlbumApiService::class);
        $this->app->bind(SongApiInterface::class, SongApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
