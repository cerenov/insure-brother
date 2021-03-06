<?php

namespace App\Providers;

use App\Repositories\ElasticsearchRepository;
use App\Repositories\InsuranceRepository;
use App\Repositories\Interfaces\ElasticsearchInterface;
use App\Repositories\Interfaces\InsuranceRepositoryInterface;
use Elasticsearch\Client;
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
            InsuranceRepositoryInterface::class,
            InsuranceRepository::class,
        );
        $this->app->bind(
            ElasticsearchInterface::class,
            ElasticsearchRepository::class,
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
