<?php

namespace App\Providers;

use App\Repositories\BookRepository;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            BookRepositoryInterface::class, 
            BookRepository::class
        );
    }
}
