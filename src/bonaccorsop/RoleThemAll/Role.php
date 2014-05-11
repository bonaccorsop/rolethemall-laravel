<?php namespace bonaccorsop\RoleThemAll;


use bonaccorsop\RoleThemAll\RolesParser as RolesParser;
use bonaccorsop\RoleThemAll\Decoders as Decoders;
use bonaccorsop\RoleThemAll\Interfaces;

use Auth;

class Role
{

	private $parsed;
	private $user;
	private $role;

	/**
	 * __construct
	 *
	 * @param RolesParser $parser
	 * @param RoleInterface $roler (optional)
	 */
	public function __construct( RolesParser $parser, /*RoleInterface*/ $user = null )
	{
		$this->parsed = $parser->parse();
		if( $user ) {
			$this->user = $user;
			$this->role = $user->getRole();
		}
	}

	protected static function getFacadeAccessor()
	{
		return 'role';
	}


	/**
	 * user
	 *
	 * Retrive the Current Logged User
	 *
	 * @return string
	 */
	public function user()
	{
		return $this->user ? $this->user : Auth::user();
	}


	/**
	 * user
	 *
	 * Retrive the Current Logged User's Role
	 *
	 * @return string
	 */
	public function role()
	{
		return $this->role ? $this->role : $this->user()->getRole();
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
		$hierarchy = Decoders::decodeList( $this->find( $this->role() ), RolesParser::CHILDS_KEY );
		return in_array( $roleName, $hierarchy );
	}


	/**
	 * can
	 *
	 * Determines if the current RoleInterface has the specified capability
	 *
	 * @param mixed $capabilityName
	 * @return bool
	 */
	public function can( $capabilityName )
	{
		foreach ( Decoders::decodeList( $capabilityName ) as $capab ) {
			if( ! in_array( $capab, Decoders::decodeList( $this->find( $this->role() ), RolesParser::CAPABILITIES_KEY ) ) ) {
				return false;
			}
		}

		return true;
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
	 * @param mixed $capabilityName
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