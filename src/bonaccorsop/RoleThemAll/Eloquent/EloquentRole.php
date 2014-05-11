<?php namespace bonaccorsop\RoleThemAll\Eloquent;

use Eloquent;

class EloquentRole extends Eloquent
{


	protected $roleField = 'role';
	private $roleDictionary = NULL;

	public function __construct()
	{
		parent::__construct();
	}


	public function can( $roleName )
	{

	}

	public function is( $roleName )
	{

	}


}