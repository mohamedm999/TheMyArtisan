<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use App\Repositories\ArtisanProfileRepository;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\BookingRepository;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\ReviewRepository;
use App\Repositories\Interfaces\ScheduleRepositoryInterface;
use App\Repositories\ScheduleRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register User Repository
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Register ArtisanProfile Repository
        $this->app->bind(ArtisanProfileRepositoryInterface::class, ArtisanProfileRepository::class);

        // Register Booking Repository
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);

        // Register Review Repository
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        
        // Register Schedule Repository
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
