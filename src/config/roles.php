<?php

return array(

	/*
    |--------------------------------------------------------------------------
    | Roles' Section
    |--------------------------------------------------------------------------
    |
    */

	'roles' => array(

		/*
	    |--------------------------------------------------------------------------
	    | List of Roles Example
	    |--------------------------------------------------------------------------
	    |
	    */

	    /*

			'god' => array(
				'aliases' => array( 'zeus' ),
				'childs' => array( '*' ),
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
			)
		*/


		'admin' => array(

			//Aliases offers other names to refer to a certain Role
			'aliases' => array( 'administrator', 'manager' ),

			//The role childs' capabilities are inherited automatically to this role
			'childs' => array( 'user' ),

			//The capabilities list of this role, what this role can do
			'capabilities' => array( 'manage', 'notify' )
		),


		'user' => array(
			'capabilities' => array( 'browse' )
		),

	)
);