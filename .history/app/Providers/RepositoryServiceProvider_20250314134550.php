<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use App\Repositories\Interfaces\WorkExperienceRepositoryInterface;
use App\Repositories\Interfaces\CertificationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\ArtisanProfileRepository;
use App\Repositories\WorkExperienceRepository;
use App\Repositories\CertificationRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArtisanProfileRepositoryInterface::class, ArtisanProfileRepository::class);
        $this->app->bind(WorkExperienceRepositoryInterface::class, WorkExperienceRepository::class);
        $this->app->bind(CertificationRepositoryInterface::class, CertificationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
