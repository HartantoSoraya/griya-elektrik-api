<?php

namespace App\Providers;

use App\Interfaces\BannerRepositoryInterface;
use App\Interfaces\BranchImageRepositoryInterface;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\ProductBrandRepositoryInterface;
use App\Interfaces\ProductCategoryRepositoryInterface;
use App\Interfaces\ProductLinkRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\WebConfigurationRepositoryInterface;
use App\Repositories\BannerRepository;
use App\Repositories\BranchImageRepository;
use App\Repositories\BranchRepository;
use App\Repositories\ProductBrandRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductLinkRepository;
use App\Repositories\ProductRepository;
use App\Repositories\WebConfigurationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(WebConfigurationRepositoryInterface::class, WebConfigurationRepository::class);
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(BranchImageRepositoryInterface::class, BranchImageRepository::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
        $this->app->bind(ProductBrandRepositoryInterface::class, ProductBrandRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductLinkRepositoryInterface::class, ProductLinkRepository::class);
        $this->app->bind(\App\Interfaces\ClientRepositoryInterface::class, \App\Repositories\ClientRepository::class);
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
