<?php


class PlanControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testGraduateIndex_shows_plan(){
        $data = $this->call('GET', 'api/1.1/plans/graduate');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['collection'],'plans');
        $this->assertEquals(count($content['plans']),148);
    }
    public function testGraduateIndex_shows_legacy_plan(){
        $data = $this->call('GET', 'plans/graduate');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['type'],'plans');
        $this->assertEquals(count($content['plans']),148);
    }

    public function testIndex_returns_json_content_for_version_one()
    {   $data = $this->call('GET','/plans');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['collection'], 'plans');
        $this->assertEquals($content['limit'], '150');
        $this->assertEquals(count($content['plans']), 148);
    }

    public function testIndex_returns_json_content_for_version_one_point_one()
    {   $data = $this->call('GET','/api/1.1/plans');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['version'], '1.1');
        $this->assertEquals($content['collection'], 'plans');
        $this->assertEquals($content['limit'], '150');
        $this->assertEquals(count($content['plans']), 148);
    }
}

