<?php

use \Mockery;

class DictionaryTest extends TestCase
{



	public function capabilitiesDataProvider()
	{
		return array(
			array( 'god', array( 'develop', 'create', 'manage', 'notify', 'review', 'browse', 'discover' ) ),
			array( 'user', array( 'browse', 'discover' ) ),
			array( 'admin', array( 'manage', 'notify', 'review', 'browse', 'discover' ) ),
			array( 'revisor', array( 'review', 'notify', 'browse', 'discover' ) )
		);
	}

	public function rolesExistsDataProvider()
	{
		return array(
			array( 'god', true ),
			array( 'user', true ),
			array( 'admin', true ),
			array( 'revisor', true ),
			array( 'sysadmin', false ),
			array( 'master', false ),
		);
	}

	public function rolesChildOfDataProvider()
	{
		return array(
			array( 'god', false, 'revisor' ),
			array( 'revisor', true, 'god' ),
			array( 'user', true, 'god' ),
			array( 'admin', true, 'god' ),
			array( 'god', false, 'admin' ),
			array( 'user', true, 'admin' ),
			array( 'user', true, 'revisor' ),
		);
	}



	public function testGetDictionary()
    {

    	$dictionary = $this->getDictionary();

    	$expectedRoles = array( 'god', 'admin', 'revisor', 'user'  );
    	$this->assertEqualsArray( $expectedRoles, $dictionary->getRoles() );

    }


    /**
    * @dataProvider capabilitiesDataProvider
    */
	public function testGetRoleCapabilities( $role, $expectedRoleCapabilities )
    {
    	$dictionary = $this->getDictionary();
    	$this->assertEqualsArray( $expectedRoleCapabilities, $dictionary->getRoleCapabilities( $role ) );
    }


    /**
    * @dataProvider rolesExistsDataProvider
    */
	public function testRoleExists( $role, $exists )
    {
    	$dictionary = $this->getDictionary();
    	$this->assertEquals( $exists, $dictionary->roleExists( $role ) );

    }

    /**
    * @dataProvider rolesChildOfDataProvider
    */
	public function testRoleChild( $child, $is, $parent )
    {
    	$dictionary = $this->getDictionary();
    	$this->assertEquals( $is, $dictionary->isChildOf( $child, $parent ) );

    }





}

