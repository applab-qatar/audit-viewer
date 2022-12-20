<?php

namespace SeinOxygen\AuditViewer\Facades;

use Illuminate\Support\Facades\Facade;

class AuditViewer extends Facade
{
    /**
     * Get the registered name of the component.
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AuditViewer';
    }
}
