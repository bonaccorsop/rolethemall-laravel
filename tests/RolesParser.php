<?php

use \Mockery;

class RolesParserTest extends TestCase
{


	public function testRolesProvider()
	{
		$provider = $this->getParser();
		$this->assertInstanceOf( 'bonaccorsop\RoleThemAll\RolesParser', $provider );
	}



	public function searchRoleDataProvider()
	{
		return array(
			array( null, 'god', true ),
			array( null, 'admin', true ),
			array( null, 'fakeRole', false ),
			array( null, 'zeus', true ),
			array( null, 'user', true ),
		);
	}

	/**
	* @dataProvider searchRoleDataProvider
	*/
	public function testSearchRole( $config, $roleNameToSearch, $isArray )
	{
		$provider = $this->getParser( $config );
		$this->assertInternalType( $isArray ? 'array' : 'bool', $provider->searchRole( $roleNameToSearch ) );
	}



	public function resolveRoleHierarchyDataProvider()
	{
		return array(
			array( null, 'god', array( 'god', 'admin', 'revisor', 'user' ) ),
			array( null, 'admin', array( 'admin', 'revisor', 'user' ) ),
			array( null, 'revisor', array( 'revisor', 'user' ) ),
			array( null, 'user', array( 'user' ) ),
		);
	}

	/**
	* @dataProvider resolveRoleHierarchyDataProvider
	*/
	public function testResolveRoleHierarchy( $config, $roleToResolve, $expectedChilds )
	{
		$provider = $this->getParser( $config );

		$resolvedChilds = $provider->resolveRoleHierarchy( $roleToResolve );
		$this->assertEquals( $expectedChilds, $resolvedChilds );
	}






	public function resolveDataProvider()
	{

		return [
			[
				$this->getConfigArray(),
				'god',
				array(
					'aliases' => array( 'god', 'zeus' ) ,
					'childs' => array( 'god', 'admin', 'revisor', 'user' ),
					'capabilities' => array( 'develop', 'create', 'manage', 'notify', 'review', 'browse', 'discover' )
				)
			],
			[
				$this->getConfigArray(),
				'admin',
				array(
					'aliases' => array( 'admin', 'administrator', 'manager' ) ,
					'childs' => array( 'admin', 'revisor', 'user' ),
					'capabilities' => array( 'manage', 'notify', 'review', 'browse', 'discover' )
				)
			],
			[
				$this->getConfigArray(),
				'revisor',
				array(
					'aliases' => array( 'revisor', 'reviewer' ) ,
					'childs' => array( 'revisor', 'user' ),
					'capabilities' => array( 'notify', 'review', 'browse', 'discover' )
				)
			],
		];
	}

	/**
	* @dataProvider resolveDataProvider
	*/
	public function testResolveRole( $config, $roleToResolve, $expectedDictionary )
	{
		$provider = $this->getParser( $config, $roleToResolve );

		$resolvedDictionary = $provider->resolveRole( $roleToResolve );
	}









}

