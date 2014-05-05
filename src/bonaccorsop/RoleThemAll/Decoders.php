<?php namespace bonaccorsop\RoleThemAll;


class Decoders
{

	public static function decodeList( $list, $key = null )
	{

		if( ! empty( $key ) ) {
			if( is_array( $list ) ) {
				$list = empty( $list[ $key ] ) ? array() : $list[ $key ];
			}
			else {
				$list = array();
			}

		}
		$list = is_array( $list ) ? $list : ( is_null( $list ) ? array() : array( $list ) );

		return $list;

	}




}