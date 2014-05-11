<?php namespace bonaccorsop\RoleThemAll\Filters;

use Response;
use Auth;

class RolesFilter
{

    /**
     * Run the oauth filter
     *
     * @param Route $route the route being called
     * @param Request $request the request object
     * @param string $scope additional filter arguments
     * @return Response|null a bad response in case the request is invalid
     */
    public function filter()
    {

        if ( func_num_args() > 2 ) {
            $args = func_get_args();
            $scopes = array_slice( $args, 2 );

            Auth::getUser()->roles()->is(  );

            foreach ($scopes as $s) {
                if (! ResourceServer::hasScope($s)) {
                    return Response::json(array(
                        'status' => 403,
                        'error' => 'forbidden',
                        'error_message' => 'Only access token with scope '.$s.' can use this endpoint',
                    ), 403);
                }
            }
        }
    }
}
