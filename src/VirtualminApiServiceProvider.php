<?php

namespace FintechSystems\VirtualminApi;

use Illuminate\Support\ServiceProvider;

class VirtualminApiServiceProvider extends ServiceProvider
{
    public function root()
    {
    }

    public function register()
    {
        // $this->app->bind('virtualmin-api', function() {
        //     return new VirtualminApi();
        // });

        $this->app->bind('virtualmin-api', function () {
            return new VirtualminApi([
                'host'     => $_ENV['VIRTUALMIN_HOST'],
                'password' => $_ENV['VIRTUALMIN_PASSWORD'],
            ]);
        });
    }
}
