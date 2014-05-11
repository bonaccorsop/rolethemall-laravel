<?php namespace bonaccorsop\RoleThemAll;

use bonaccorsop\RoleThemAll\RolesParser as RolesParser;

class Role
{

	private $parsed;
	private $role;

	/**
	 * __construct
	 *
	 * @param RolesParser $parser
	 * @param RoleInterface $roler
	 */
	public function __construct( RolesParser $parser, $roler )
	{
		$this->parsed = $parser->parse();
		$this->role = $roler->getRole();
	}

	/**
	 * current
	 *
	 * Retrive the Current Logged Role
	 *
	 * @return string
	 */
	public function current()
	{
		return $this->role;
	}


	/**
	 * find
	 *
	 * Find a role Dictionary by name
	 *
	 * @param string $roleName
	 * @return array
	 */
	public function find( $roleName )
	{
		$roles = Decoders::decodeList( $this->parsed );

		foreach ( $roles as $key => $dict ) {
			if( in_array( $roleName, Decoders::decodeList( $dict, RolesParser::ALIASES_KEY ) ) ) {
				return $dict;
			}
		}

		return array();
	}


	/**
	 * is
	 *
	 * Determines if the current RoleInterface is a has the specified role
	 *
	 * @param string $roleName
	 * @return bool
	 */
	public function is( $roleName )
	{
		$hierarchy = Decoders::decodeList( $this->find( $this->role ), RolesParser::CHILDS_KEY );
		return in_array( $roleName, $hierarchy );
	}


	/**
	 * can
	 *
	 * Determines if the current RoleInterface has the specified capability
	 *
	 * @param string $capabilityName
	 * @return bool
	 */
	public function can( $capabilityName )
	{
		return in_array( $capabilityName, Decoders::decodeList( $this->find( $this->role ), RolesParser::CAPABILITIES_KEY ) );
	}


	/**
	 * isOrFail
	 *
	 * Throw an Exception if the current RoleInterface is a hasn't the specified role
	 *
	 * @param string $roleName
	 * @throw bonaccorsop\RoleThemAll\Exceptions\ForbiddenException
	 * @return bool
	 */
	public function isOrFail( $roleName )
	{
		if( ! $this->is( $roleName ) ) {
			throw new bonaccorsop\RoleThemAll\Exceptions\ForbiddenException;
		}

		return true;
	}


	/**
	 * canOrFail
	 *
	 * Throw an Exception if the current RoleInterface is a hasn't the specified capability
	 *
	 * @param string $capabilityName
	 * @throw bonaccorsop\RoleThemAll\Exceptions\ForbiddenException
	 * @return bool
	 */
	public function canOrFail( $capabilityName )
	{
		if( ! $this->can( $capabilityName ) ) {
			throw new bonaccorsop\RoleThemAll\Exceptions\ForbiddenException;
		}

		return true;
	}




}