<?php

use Curriculum\Http\Controllers\ClassController;

class ClassControllerTest extends TestCase
{
    protected $classController;
    protected $classId;
    public function setUp(){
        parent::setUp();
      $this->classId = 'comp-100';
    }
    public function testShow_shows_class(){
        $data = $this->call('GET', 'api/1.1/terms/Spring-2015/classes/' . $this->classId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']),17);
    }
}
