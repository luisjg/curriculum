<?php

class PlanControllerTest extends TestCase
{
    protected $planId;
    public function setUp(){
        parent::setUp();
        $this->planId = '561208M';
    }

    public function testGraduateIndex_shows_plan(){
        $data = $this->call('GET', 'api/2.0/plans/graduate');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['collection'], 'plans');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }
      
    public function testShow_shows_plan(){
        $data = $this->call('GET', 'api/2.0/plans/' . $this->planId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['collection'], 'plan');
        $this->assertEquals(($content['plan']['plan_id']), $this->planId);
    }
        
    public function testGraduateIndex_shows_legacy_plan(){
        $data = $this->call('GET', 'api/plans/graduate');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'plans');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }

    public function testShow_shows_legacy_plan(){
        $data = $this->call('GET', 'api/plans/' . $this->planId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'plans');
        $this->assertEquals(($content['plans']['plan_id']), $this->planId);
    }

    public function testIndex_returns_json_content_for_version_one()
    {   $data = $this->call('GET','api/plans');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['collection'], 'plans');
//        $this->assertEquals($content['limit'], '150');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }

    public function testIndex_returns_json_content_for_version_one_point_one()
    {   $data = $this->call('GET','/api/2.0/plans');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['collection'], 'plans');
//        $this->assertEquals($content['limit'], '150');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }
}

