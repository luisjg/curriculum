<?php

use Curriculum\Http\Controllers\PlanController;

class PlanControllerTest extends TestCase
{
    protected $planId;
    public function setUp(){
        parent::setUp();
        $this->planId=561208;
    }
    public function testShow_shows_plan(){
        $data = $this->call('GET', 'api/1.1/plans/' . $this->planId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['collection'],'plan');
        $this->assertEquals(($content['plan']['plan_id']),$this->planId);
    }
    public function testShow_shows_legacy_plan(){
        $data = $this->call('GET', 'plans/' . $this->planId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['type'],'plans');
        $this->assertEquals(($content['plans']['plan_id']),$this->planId);
    }
}
