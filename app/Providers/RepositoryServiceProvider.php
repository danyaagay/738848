<?php

namespace App\Providers;

use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ProductRepositoryInterface::class, 
            ProductRepository::class
        );
    }
}
