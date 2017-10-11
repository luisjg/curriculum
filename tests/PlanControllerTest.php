<?php


class PlanControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testIndex_returns_json_content_for_all_versions()
    {   $data = $this->call('GET','/plans');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['version'], '1.1');
        $this->assertEquals($content['collection'], 'plans');
        $this->assertEquals($content['limit'], '150');
        $this->assertEquals(count($content['plans']), 148);
    }
}