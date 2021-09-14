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

	    public function register() {

   //     $this->app->register(\Tymon\JWTAuth\Providers\LumenServiceProvider::class);

	//$this->app->bind(UserTypeRepositoryInterface::class, UserTypeRepositoryEloquent::class);

        $this->app->bind('App\Repositories\UserTypeRepositoryInterface', 'App\Repositories\UserTypeRepositoryEloquent');
       // $this->app->bind('App\Repositories\CategoriaProdutosRepositoryInterface', 'App\Repositories\CategoriaProdutosRepositoryEloquent');
       // $this->app->bind('App\Repositories\ProdutoRepositoryInterface', 'App\Repositories\ProdutoRepositoryEloquent');
    }
}
