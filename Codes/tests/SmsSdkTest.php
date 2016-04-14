<?php

class SmsSdkTest extends PHPUnit_Framework_TestCase
{
    public function testSmsPost(){
        $response = SmsService::send("Test message at ".time(), '84092272');
        $this->assertEquals("2000 = SUCCESS", $response);
    }
}