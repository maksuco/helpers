<?php

namespace Maksuco\helpers\Facades;

use Illuminate\Support\Facades\Facade;

class helpers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ('maksuco-helpers');
    }
}
