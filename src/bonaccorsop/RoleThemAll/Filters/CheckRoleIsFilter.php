<?php namespace bonaccorsop\RoleThemAll\Filters;

use bonaccorsop\RoleThemAll\Role;

class CheckRoleIsFilter
{

    /**
     * Run the oauth filter
     *
     * @param Route $route the route being called
     * @param Request $request the request object
     * @param string $roles additional filter arguments
     * @return Response|null a bad response in case the request is invalid
     */
    public function filter()
    {

        if ( func_num_args() > 2 ) {

            $args = func_get_args();
            $roles = array_slice( $args, 2 );

            Role::isOrFail( $roles );

        }
    }
}