<?php

class AuthRouteTest extends PHPUnit_Framework_TestCase
{
    public function testGuestAuthRoute(){
        $ar = new AuthRoute(CMS::ROLE_GUEST.'#public@landingPage');
        $this->assertEquals(CMS::ROLE_GUEST.'#public@landingPage', $ar->getName());
        $this->assertEquals([0], $ar->getRoles());
        $this->assertEquals(true, $ar->isAllowed(0));
        $this->assertEquals(false, $ar->isAllowed(1));
        $this->assertEquals('public', $ar->getGroup());
        $this->assertEquals('landingPage', $ar->getAction());
        $this->assertEquals('landingPage', $ar->getSecondGroup());
    }
    
    public function testCallOperatorAuthRoute(){
        $ar = new AuthRoute(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-active');
        $this->assertEquals(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-active', $ar->getName());
        $this->assertEquals([1, 3], $ar->getRoles());
        $this->assertEquals(false, $ar->isAllowed(0));
        $this->assertEquals(true, $ar->isAllowed(3));
        $this->assertEquals('incident', $ar->getGroup());
        $this->assertEquals('list-active', $ar->getAction());
        $this->assertEquals('list-active', $ar->getSecondGroup());
    }
    
    public function testAgencyAuthRoute(){
        $ar = new AuthRoute(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-active');
        $this->assertEquals(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-active', $ar->getName());
        $this->assertEquals([1, 3], $ar->getRoles());
        $this->assertEquals(false, $ar->isAllowed(0));
        $this->assertEquals(true, $ar->isAllowed(1));
        $this->assertEquals(true, $ar->isAllowed(3));
        $this->assertEquals('incident', $ar->getGroup());
        $this->assertEquals('list-active', $ar->getAction());
        $this->assertEquals('list-active', $ar->getSecondGroup());
    }
    
    public function testKeyDecisionMakerAuthRoute(){
        $ar = new AuthRoute(CMS::ROLE_KEY_DECISION_MAKER.'#crisis@activate');
        $this->assertEquals(CMS::ROLE_KEY_DECISION_MAKER.'#crisis@activate', $ar->getName());
        $this->assertEquals([5], $ar->getRoles());
        $this->assertEquals(false, $ar->isAllowed(3));
        $this->assertEquals(true, $ar->isAllowed(5));
        $this->assertEquals('crisis', $ar->getGroup());
        $this->assertEquals('activate', $ar->getAction());
        $this->assertEquals('activate', $ar->getSecondGroup());
    }
}