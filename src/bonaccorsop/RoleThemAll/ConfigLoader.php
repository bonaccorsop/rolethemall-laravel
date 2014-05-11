<?php namespace bonaccorsop\RoleThemAll;

use Config;

class ConfigLoader
{

	public function make()
	{
		return Config::get( 'bonaccorsop/rolethemall::roles' );
	}



}

