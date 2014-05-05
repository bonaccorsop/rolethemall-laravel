<?php namespace bonaccorsop\RoleThemAll;

class Roles
{

	private $role = NULL;
	private $dictionary = NULL;

	public function __construct( Dictionary $dictionary, $role )
	{
		$this->_setDictionary( $dictionary );
		$this->setRole( $role );
	}

	private function _setDictionary( Dictionary $dictionary )
	{
		$this->dictionary = $dictionary;
	}

	public function setRole( $role )
	{
		$this->role = $role;
	}

	public function getRole()
	{
		return $this->role;
	}

	public function is( $roleName )
	{
		return in_array( $roleName, array_merge( array( $this->role ), $this->dictionary->getChilds( $this->role ) ) );
	}

	public function can( $capabilityName )
	{
		return in_array( $capabilityName, $this->dictionary->getRoleCapabilities( $this->role ) );
	}


	public function isOrFail( $roleName )
	{
		if( ! $this->is( $roleName ) ) {
			throw new bonaccorsop\RoleThemAll\Exceptions\ForbiddenException;
		}

		return true;
	}

	public function canOrFail( $capabilityName )
	{
		if( ! $this->can( $capabilityName ) ) {
			throw new bonaccorsop\RoleThemAll\Exceptions\ForbiddenException;
		}

		return true;
	}













}