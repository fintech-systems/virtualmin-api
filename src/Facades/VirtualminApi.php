<?php

namespace FintechSystems\VirtualminApi\Facades;

use Illuminate\Support\Facades\Facade;

class VirtualminApi extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'virtualmin-api';
    }
}