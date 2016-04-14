<?php

class CoreTest extends PHPUnit_Framework_TestCase
{
    public function testHashing(){
        $this->assertEquals(hash('sha256', 'asdjbask'.CMS::SALT), Core::createHashing('asdjbask'));
    }
    
    public function testNullChecker(){
        $this->assertEquals(false, Core::checkNullValue(null));
        $this->assertEquals(false, Core::checkNullValue(''));
        $this->assertEquals(true, Core::checkNullValue(0));
        $this->assertEquals(true, Core::checkNullValue('a'));
        $this->assertEquals(true, Core::checkNullValue(0.2));
    }
    
    public function checkUserRoleConversion(){
        $this->assertEquals('Call Operator', Core::getUserRoleString(new CallOperator()));
        $this->assertEquals('Agency', Core::getUserRoleString(new Agency()));
        $this->assertEquals('Key Decision Maker', Core::getUserRoleString(new KeyDecisionMaker()));
        $this->assertEquals('Minister', Core::getUserRoleString(new Minister()));
    }
}