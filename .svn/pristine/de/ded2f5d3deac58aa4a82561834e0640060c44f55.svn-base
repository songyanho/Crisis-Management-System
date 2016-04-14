<?php

class TwitterSdkTest extends PHPUnit_Framework_TestCase
{
    public function testTwitterTweetPost(){
        $response = TwitterService::send("Test message at ".time());
        $this->assertEquals(710739994072100864, $response["user"]["id"]);
    }
}