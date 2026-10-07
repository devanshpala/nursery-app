<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Interfaces\ChildRepositoryInterface::class,
            \App\Repositories\Eloquent\ChildRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\StaffRepositoryInterface::class,
            \App\Repositories\Eloquent\StaffRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TenantRepositoryInterface::class,
            \App\Repositories\Eloquent\TenantRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\RoomRepositoryInterface::class,
            \App\Repositories\Eloquent\RoomRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\RoomAttendanceRepositoryInterface::class,
            \App\Repositories\Eloquent\RoomAttendanceRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\NurseryRepositoryInterface::class,
            \App\Repositories\Eloquent\NurseryRepository::class
        );
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
