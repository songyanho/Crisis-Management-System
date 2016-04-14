<?php

class AuthenticationTest extends PHPUnit_Framework_TestCase
{
    public function testAuthentication(){
        $auth = new Authentication(null, null);
        $this->assertEquals(true, $auth->publicAccess('public'));
        $this->assertEquals(true, $auth->restrictedAccess([CMS::ROLE_GUEST], new User(), 'login'));
        $this->assertEquals(true, $auth->userAccess(new User()));
    }
}