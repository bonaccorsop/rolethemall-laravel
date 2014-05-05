<?php namespace bonaccorsop\RoleThemAll;

use bonaccorsop\RoleThemAll as RTA;
use Illuminate\Support\Facades\Facade;

class Dictionary
{

	private $dictArray = array();

	public function __construct( ConfigLoader $configLoader )
	{
		$this->dictArray = $configLoader->make();
	}

	private function _sanitizeName( $string )
	{
		return strtolower( $string );
	}


	private function _getRolesArray()
	{
		return isset( $this->dictArray[ 'roles' ] ) ? $this->dictArray[ 'roles' ] : array();
	}

	public function getRoles()
	{
		return array_keys( $this->_getRolesArray() );
	}


	public function searchRole( $name )
	{
		$name = $this->_sanitizeName( $name );
		$roles = $this->_getRolesArray();

		foreach ( $roles as $roleName => $content ) {
			$aliases = array_merge( array( $name ), $this->getAliases( $content ) );
			if( in_array( $name, array( $roleName ) /*$aliases*/ ) ) {
				return $roles[ $name ];
			}
		}

		return false;
	}




	private function getAliases( $role )
	{
		$aliases = RTA\Decoders::decodeList( $role, 'aliases' );
		$aliases = array_unique( $aliases );

		return $aliases;

	}


	public function getCapabilities( $roleName )
	{
		$role = $this->searchRole( $roleName );

		$capabilities = RTA\Decoders::decodeList( $role, 'capabilities' );
		$capabilities = array_unique( $capabilities );

		return $capabilities;

	}


	public function getChilds( $roleName )
	{
		$role = $this->searchRole( $roleName );

		$childs = RTA\Decoders::decodeList( $role, 'childs' );

		foreach ( $childs as $key => $child ) {
			if( $child == '*' ) {
				unset( $childs[ $key ] );
				$childs = array_merge( $childs,  array_diff( $this->getRoles(), array( $roleName ) ) );
			}
		}

		$childs = array_unique( $childs );

		return $childs;

	}




	/**
	 * getCapabilities
	 *
	 * Retrive capabilities of a particular role
	 *
	 * @param (string) $roleName
	 * @return array<T>
	 */
	public function getRoleCapabilities( $roleName )
	{

		$capabilities = $this->getCapabilities( $roleName );
		$childs = $this->getChilds( $roleName );


		foreach ( $childs as $child ) {
			$capabilities = array_merge( $capabilities, $this->getRoleCapabilities( $child ) );
		}

		return array_unique( $capabilities );

	}


	/**
	 * roleExists
	 *
	 * @param (string) $roleName
	 * @return bool
	 */
	public function roleExists( $roleName )
	{
		return $this->searchRole( $roleName ) != false;

	}


	/**
	 * isChildOf
	 *
	 * @param (string) $childRole
	 * @param (string) $parentRole
	 * @return bool
	 */
	public function isChildOf( $childRole, $parentRole )
	{
		return in_array( $childRole, $this->getChilds( $parentRole ) );
	}



	public function getRoleAliases( $roleName )
	{
		$roles = $this->_getRolesArray();

		$out = array();

		if( isset( $roles[ $roleName ] ) ) {
			$aliases = isset( $roles[ $roleName ][ 'aliases' ] ) ? $roles[ $roleName ][ 'aliases' ] : array();
			$out = array_unique( array_merge( array( $roleName ), $aliases ) );
		}

		return $out;
	}











}