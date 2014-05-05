<?php

class TestCase extends Orchestra\Testbench\TestCase {




	public function getConfigArray()
	{
		return array(
			'connection' => 'array',
			'roles' => array(

				'god' => array(
					'aliases' => array( 'zeus' ),
					'childs' => '*',
					'capabilities' => array( 'develop', 'create' )
				),

				'admin' => array(
					'aliases' => array( 'administrator', 'manager' ),
					'childs' => array( 'revisor', 'user' ),
					'capabilities' => array( 'manage', 'notify', 'manage' )
				),

				'revisor' => array(
					'aliases' => array( 'reviewer' ),
					'childs' => array( 'user' ),
					'capabilities' => array( 'review', 'notify' )
				),

				'user' => array(
					'aliases' => array( 'navigator', 'browser' ),
					'capabilities' => array( 'browse', 'discover' )
				),
			)
		);
	}

	public function getDictionary( $config = NULL )
	{

		$config = ! empty( $config ) ? $config : $this->getConfigArray();

		$ConfigLoaderClass = 'bonaccorsop\RoleThemAll\ConfigLoader';
    	$configLoader = \Mockery::mock( $ConfigLoaderClass, array( 'make' => $config ) );

    	$dictionary = new bonaccorsop\RoleThemAll\Dictionary( $configLoader );

    	return $dictionary;
	}


	public function assertEqualsArray( $expectedArray, $array, $message = null )
	{
		$this->assertEquals( count( $expectedArray ), count( $array ), $message );
	}

}