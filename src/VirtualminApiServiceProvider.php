<?php

namespace FintechSystems\VirtualminApi;

use Illuminate\Support\ServiceProvider;

class VirtualminApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind('virtualmin-api', function () {
            return new VirtualminApi([                
                'hostname' => env('VIRTUALMIN_HOSTNAME'),
                'username' => env('VIRTUALMIN_USERNAME'),
                'password' => env('VIRTUALMIN_PASSWORD'),
                'port'     => env('VIRTUALMIN_PORT'),

            ], env('VIRTUALMIN_API_MODE'));
        });
    }
}
