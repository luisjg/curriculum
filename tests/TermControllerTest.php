<?php

use Curriculum\Http\Controllers\ClassController;

class TermControllerTest extends TestCase
{
    protected $classId;
    public function setUp(){
        parent::setUp();
      $this->classId = 'comp-100';
    }
    public function testClassesShow_shows_classes(){
        $data = $this->call('GET', 'api/1.1/terms/Spring-2015/classes/' . $this->classId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']),17);
    }
    public function testClassesShow_shows_legacy_classes(){
        $data = $this->call('GET', 'terms/Spring-2015/classes/' . $this->classId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['type'],'classes');
        $this->assertEquals(count($content['classes']),17);
    }
}
