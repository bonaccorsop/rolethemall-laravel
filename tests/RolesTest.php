<?php

use \Mockery;

class RolesTest extends TestCase
{


	public function getRoles( $roleName, array $config = NULL )
	{
		$dictionary = $this->getDictionary( $config );
    	$role = new bonaccorsop\RoleThemAll\Roles( $dictionary, $roleName );
    	return $role;
	}



	public function roleCapabilitiesDataProvider()
	{
		return array(
			array( 'god', true, 'develop' ),
			array( 'user', false, 'develop' ),
			array( 'revisor', true, 'discover' ),
			array( 'admin', true, 'discover' ),
			array( 'admin', true, 'browse' ),
			array( 'god', true, 'notify' ),
			array( 'admin', false, 'develop' ),
			array( 'user', false, 'develop' ),
			array( 'revisor', false, 'create' ),
		);
	}

	public function roleIsDataProvider()
	{
		return array(
			array( 'god', true, 'user' ),
			array( 'admin', true, 'user' ),
			array( 'user', false, 'revisor' ),
			array( 'revisor', false, 'god' ),
			array( 'revisor', true, 'user' ),
			array( 'revisor', true, 'revisor' ),
		);
	}



	public function testGetRoles()
    {
    	$this->assertInstanceOf( 'bonaccorsop\RoleThemAll\Roles', $this->getRoles( 'revisor' ) );
    }

	public function testGetRole()
    {
    	$roles = $this->getRoles( 'revisor' );
    	$this->assertEquals( 'revisor', $roles->getRole() );
    }

    /**
    * @dataProvider roleIsDataProvider
    */
	public function testRoleIs( $role, $is, $roleTest )
    {
    	$roles = $this->getRoles( $role );

    	$results = $roles->is( $roleTest );
    	$this->assertEquals( $is, $results );
    }

	/**
    * @dataProvider roleCapabilitiesDataProvider
    */
	public function testRoleCapabilities( $role, $can, $capability )
    {
    	$roles = $this->getRoles( $role );

    	$results = $roles->can( $capability );
    	$this->assertEquals( $can, $results );
    }






}

