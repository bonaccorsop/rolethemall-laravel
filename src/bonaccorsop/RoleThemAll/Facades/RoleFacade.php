<?php namespace bonaccorsop\RoleThemAll\Facades;

use Illuminate\Support\Facades\Facade;

class RoleFacade extends Facade
{
	protected static function getFacadeAccessor() {
        return 'Role';
    }
}