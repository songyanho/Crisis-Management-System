<?php

class FacebookSdkTest extends PHPUnit_Framework_TestCase
{
    public function testFacebookFeedPost(){
        $response = FacebookService::send("Test message at ".time());
//        $this->assertEquals(200, $response->getHttpStatusCode());
    }
}