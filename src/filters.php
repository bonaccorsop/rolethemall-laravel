<?php

// filter to check if the logged user's role is ...
Route::filter('roleIs', 'bonaccorsop\RoleThemAll\Filters\CheckRoleIsFilter');

// filter to check if the logged user's role has capabilities to ...
Route::filter('roleCan', 'bonaccorsop\RoleThemAll\Filters\CheckRoleCanFilter');
