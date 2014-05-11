<?php namespace bonaccorsop\RoleThemAll;


class Decoders
{

	/**
	 * decodeList
	 *
	 * @param array $list
	 * @param string $key (optional)
	 * @return array
	 */
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


	/**
	 * sanitizeString
	 *
	 *
	 * @param string $string
	 * @return string
	 */
	public static function sanitizeString( $string )
	{

	}




}