<?php

namespace RiseTechApps\HasUuid;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RiseTechApps\HasUuid\Skeleton\SkeletonClass
 */
class HasUuidFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hasuuid';
    }
}
