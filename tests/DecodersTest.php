<?php

use bonaccorsop\RoleThemAll as RTA;

class DecodersTest extends TestCase
{


    public function testDecodeList()
    {
    	$res = RTA\Decoders::decodeList( 'trial' );
    	$this->assertEquals( array( 'trial' ), $res );

    	$res = RTA\Decoders::decodeList( NULL );
    	$this->assertEquals( array(), $res );

    }

    public function testDecodeListWithKey()
    {
    	$array = array( 'key' => 'val' );

    	$res = RTA\Decoders::decodeList( $array, 'key' );
    	$this->assertEquals( array( 'val' ), $res );

    	$res = RTA\Decoders::decodeList( $array, 'key2' );
    	$this->assertEquals( array(), $res );

    }

    public function testDecodeListWithKeyNotArray()
    {
    	$invalidArray = 'fakeArray';

    	$res = RTA\Decoders::decodeList( $invalidArray, 'key' );
    	$this->assertEquals( array(), $res );

    }





}

