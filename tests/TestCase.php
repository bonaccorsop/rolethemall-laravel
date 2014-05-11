<?php

class TestCase extends Orchestra\Testbench\TestCase {



	protected function getPackageProviders()
    {
        return array('bonaccorsop\RoleThemAll\RoleServiceProvider');
    }

    protected function getPackageAliases()
    {
        return array(
            'Role' => 'bonaccorsop\RoleThemAll\Role',
        );
    }


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
					'childs' => array( 'revisor' ),
					'capabilities' => array( 'manage', 'notify', 'manage' )
				),

				'revisor' => array(
					'aliases' => array( 'reviewer' ),
					'childs' => array( 'user' ),
					'capabilities' => array( 'review', 'notify' )
				),

				'user' => array(
					'aliases' => array( 'navigator', 'browser' ),
					'capabilities' => array( 'browse', 'discover' ),
				),
			)
		);
	}

	public function getParser( $config = NULL )
	{

		$config = ! empty( $config ) ? $config : $this->getConfigArray();

		$ConfigLoaderClass = 'bonaccorsop\RoleThemAll\ConfigLoader';
    	$configLoader = \Mockery::mock( $ConfigLoaderClass, array( 'make' => $config ) );

    	$provider = new bonaccorsop\RoleThemAll\RolesParser( $configLoader );

    	return $provider;
	}



	public function assertStructEquals( $expected, $check, $message = null )
	{

		$h1 = strlen( $this->hashDataStruct( $expected ) );
		$h2 = strlen( $this->hashDataStruct( $check ) );

		$this->assertEquals( $h1, $h2, $message );
	}


	public function hashDataStruct( $struct )
	{
		$array = str_split( serialize( $struct ) );
		sort( $array );
		return implode( '', $array );
	}

}