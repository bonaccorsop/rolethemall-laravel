<?php

use \Mockery;
use bonaccorsop\RoleThemAll\Interfaces\RoleInterface;

class RoleTest extends TestCase
{


	public function getRole( $roleName, array $config = null )
	{
		$parser = $this->getParser( $config );

		$roler = \Mockery::mock( 'RoleInterface', array( 'getRole' => $roleName ) );

    	$role = new bonaccorsop\RoleThemAll\Role( $parser, $roler );
    	return $role;
	}


	public function testCurrentRole()
    {
    	$role = $this->getRole( 'revisor' );
    	$this->assertEquals( 'revisor', $role->role() );
    }




    public function findDataProvider()
	{
		return array(
			array(
				null,
				'revisor',
				array(
					'aliases' => array( 'revisor', 'reviewer' ) ,
					'childs' => array( 'revisor', 'user' ),
					'capabilities' => array( 'notify', 'review', 'browse', 'discover' )
				)
			)
		);
	}

	/**
    * @dataProvider findDataProvider
    */
	public function testFind( $config, $roleToFind, $expected )
    {
    	$role = $this->getRole( 'neverMind', $config );
    	$this->assertStructEquals( $expected, $role->find( $roleToFind ) );
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

    /**
    * @dataProvider roleIsDataProvider
    */
	public function testRoleIs( $role, $is, $roleTest )
    {
    	$role = $this->getRole( $role );
    	$this->assertEquals( $is, $role->is( $roleTest ) );
    }



    public function roleCapabilitiesDataProvider()
	{
		return array(
			array( 'god', true, array( 'develop', 'discover' ) ),
			array( 'user', false, 'develop' ),
			array( 'revisor', true, 'discover' ),
			array( 'admin', true, 'discover' ),
			array( 'admin', true, 'browse' ),
			array( 'god', true, 'notify' ),
			array( 'admin', false, 'develop' ),
			array( 'user', false, 'develop' ),
			array( 'user', true, array( 'discover' ) ),
			array( 'user', false, array( 'discover', 'develop' ) ),
			array( 'user', true, 'discover' ),
			array( 'revisor', false, 'create' ),
		);
	}

	/**
    * @dataProvider roleCapabilitiesDataProvider
    */
	public function testRoleCapabilities( $role, $can, $capability )
    {
    	$role = $this->getRole( $role );

    	$results = $role->can( $capability );
    	$this->assertEquals( $can, $results );
    }






}

