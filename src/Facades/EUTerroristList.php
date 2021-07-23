<?php

namespace Jota\EUTerroristList\Facades;

use Illuminate\Support\Facades\Facade;

class EUTerroristList extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'EUTerroristList';
    }
}
