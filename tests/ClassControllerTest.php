<?php

use Curriculum\Http\Controllers\ClassController;

class ClassControllerTest extends TestCase
{
    protected $classController;
    protected $classId = 'comp-100';
    protected $validEmail =  'steve@metalab.csun.edu';
    public function setUp(){
        parent::setUp();
    }
    public function testShow_shows_class(){
        $data = $this->call('GET', 'api/1.1/classes/15015');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']),1);
    }
    public function testShow_shows_legacy_class(){
        $data = $this->call('GET', 'classes/15015');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['type'],'classes');
        $this->assertEquals(count($content['classes']),1);
    }
  
   public function testIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET', '/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['type'],'classes');
        $this->assertEquals(count($content['classes']),3);
    }

    public function testIndex_returns_json_content_for_version_one_point_one()
    {
        $data = $this->call('GET', 'api/1.1/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']),3);
    }
}