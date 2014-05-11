<?php namespace bonaccorsop\RoleThemAll;

use bonaccorsop\RoleThemAll as RTA;

class RolesParser
{


	private $config = null;

	public $lockedRole;

	private static $resolved = null;


	const ROLES_KEY = 'roles';
	const ALIASES_KEY = 'aliases';
	const CAPABILITIES_KEY = 'capabilities';
	const CHILDS_KEY = 'childs';


	public function __construct( ConfigLoader $configLoader = null )
	{
		if( $configLoader ) {
			$this->loadConfig( $configLoader );
		}

	}


	/**
	 * loadConfig
	 *
	 * Load the config file
	 *
	 * @param ConfigLoader $configLoader
	 * @return void
	 */
	public function loadConfig( ConfigLoader $configLoader )
	{
		$this->config = $configLoader->make();
		$this->lockedRole = null;
	}


	/**
	 * sanitizeName
	 *
	 *
	 *
	 * @param string $string
	 * @return string
	 */
	private function sanitizeName( $string )
	{
		return strtolower( $string );
	}

	/**
	 * getRolesArray
	 *
	 *
	 *
	 * @return array
	 */
	private function getRolesArray()
	{
		return isset( $this->config[ self::ROLES_KEY ] ) ? $this->config[ self::ROLES_KEY ] : array();
	}


	/**
	 * getAllRoles
	 *
	 *
	 *
	 * @return array
	 */
	public function getAllRoles()
	{
		return array_keys( $this->getRolesArray() );
	}

	/**
	 * getAliases
	 *
	 * Retrive the role aliases in the config Array
	 *
	 * @param array $role The role dictionary
	 * @return array
	 */
	private function getAliases( $role )
	{
		$aliases = RTA\Decoders::decodeList( $role, self::ALIASES_KEY );
		$aliases = array_unique( $aliases );

		return $aliases;
	}

	/**
	 * getCapabilities
	 *
	 * Retrive the role capabilities in the config Array
	 *
	 * @param array $role The role dictionary
	 * @return array
	 */
	private function getCapabilities( $role )
	{
		$capabilities = RTA\Decoders::decodeList( $role, self::CAPABILITIES_KEY );
		$capabilities = array_unique( $capabilities );

		return $capabilities;
	}

	/**
	 * getChilds
	 *
	 * Retrive the role childs in the config Array
	 *
	 * @param string $roleName The role's name
	 * @return array
	 */
	private function getChilds( $roleName )
	{
		$role = $this->searchRole( $roleName );
		$childs = RTA\Decoders::decodeList( $role, self::CHILDS_KEY );

		//parse child shortcuts
		foreach ( $childs as $key => $child ) {
			if( $child == '*' ) {
				unset( $childs[ $key ] );
				$childs = array_merge( $childs, $this->getAllRoles() );
			}
		}

		$childs = array_diff( $childs, array( $roleName ) );

		$childs = array_unique( $childs );


		return $childs;
	}


	/**
	 * searchRole
	 *
	 * Search the role in the config Array
	 *
	 * @param string $nameToFind The role name to find
	 * @return array|false
	 */
	public function searchRole( $nameToFind )
	{
		$nameToFind = $this->sanitizeName( $nameToFind );
		$roles = $this->getRolesArray();

		foreach ( $roles as $roleName => $content ) {
			$aliases = array_merge( array( $roleName ), $this->getAliases( $content ) );
			if( in_array( $nameToFind, array_merge( array( $roleName ), $aliases ) ) ) {
				return $roles[ $roleName ];
			}
		}

		return false;
	}


	/**
	 * resolveRoleHierarchy
	 *
	 * Return a complete array hierarchy of a certain role
	 *
	 * @param string $roleName The name of role to resolve
	 * @return array
	 */
	public function resolveRoleHierarchy( $roleName )
	{
		$role = $this->searchRole( $roleName );

		if( $role != false ) {

			$childs = $this->getChilds( $roleName );
			$hierarchyList = array( $roleName );

			foreach ( $childs as $child ) {
				if( $child != $this->lockedRole ) {
					$hierarchyList = array_merge( $hierarchyList, $this->resolveRoleHierarchy( $child ) );
				}
			}

			return array_unique( $hierarchyList );
		}

		return array();

	}


	/**
	 * resolveRole
	 *
	 * Resolve the Role Hierarchy and Capabilities
	 *
	 * @return array
	 */
	public function resolveRole( $roleName )
	{

		$resolvedRoles = $this->resolveRoleHierarchy( $roleName );

		//resolve capabilities
		$resolvedCapabilities = array();
		foreach ( $resolvedRoles as $resolvedRole ) {
			foreach ( $this->getCapabilities( $this->searchRole( $resolvedRole ) ) as $capability ) {
				array_push( $resolvedCapabilities, $capability );
			}
		}
		$resolvedCapabilities = array_unique( array_values( $resolvedCapabilities ) );

		//resolve aliases
		$resolvedAliases = array_unique( array_merge( array( $roleName ), $this->getAliases( $this->searchRole( $roleName ) ) ) );

		return array(
			self::CHILDS_KEY => $resolvedRoles,
			self::CAPABILITIES_KEY => $resolvedCapabilities,
			self::ALIASES_KEY => $resolvedAliases
		);


	}

	/**
	 * parse
	 *
	 * Parse the config and make a in-memory Dictionary
	 *
	 * @return array
	 */
	public function parse()
	{

		$dictionary = array();

		foreach ( $this->getAllRoles() as $roleName ) {
			$dictionary[ $roleName ] = $this->resolveRole( $roleName );
		}

		return $dictionary;

	}






}