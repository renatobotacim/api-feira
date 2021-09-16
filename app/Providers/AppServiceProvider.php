<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        /**
         * comando para registrar o provaider para quando for habilitar autencicação via jwt
         */
        //     $this->app->register(\Tymon\JWTAuth\Providers\LumenServiceProvider::class);

        $this->app->bind('App\Repositories\UserTypeRepositoryInterface', 'App\Repositories\UserTypeRepositoryEloquent');
        $this->app->bind('App\Repositories\TransactionsRepositoryInterface', 'App\Repositories\TransactionsRepositoryEloquent');
        $this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepositoryEloquent');
    }

}
