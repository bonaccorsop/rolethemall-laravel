<?php namespace bonaccorsop\RoleThemAll\Filters;

use bonaccorsop\RoleThemAll\Role;

class CheckRoleCanFilter
{

    /**
     * Run the oauth filter
     *
     * @param Route $route the route being called
     * @param Request $request the request object
     * @param string $capabilities additional filter arguments
     * @return Response|null a bad response in case the request is invalid
     */
    public function filter()
    {

        if ( func_num_args() > 2 ) {

            $args = func_get_args();
            $capabilities = array_slice( $args, 2 );

            Role::canOrFail( $capabilities );

        }
    }
}