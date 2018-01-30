<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TermControllerTest extends TestCase
{

    protected $validEmail;
    protected $validTerm;
    protected $validClassId;
    protected $validClassId2;

    public function setUp(){
        parent::setUp();
        $this->validEmail = 'steve@metalab.csun.edu';
        $this->validTerm = 2153;
        $this->validClassId = 19149;
        $this->validClassId2 = 'comp-100';
    }

    public function testClassesShow_shows_classes(){
        $data = $this->call('GET', 'api/1.1/terms/Spring-2015/classes/' . $this->validClassId2);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }
    public function testClassesShow_shows_legacy_classes(){
        $data = $this->call('GET', 'terms/Spring-2015/classes/' . $this->validClassId2);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['type'],'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }

    public function testClassesIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET','/terms/' . $this->validTerm . '/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }

    public function testClassesIndex_returns_json_content_for_version_one_point_one()
    {
        $data = $this->call('GET','api/1.1/terms/' . $this->validTerm . '/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.1');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['collection'], 'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }

    public function testCoursesIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET','/terms/' . $this->validTerm . '/courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }

    public function testCoursesIndex_returns_json_content_for_version_one_point_one()
    {
        $data = $this->call('GET','api/1.1/terms/' . $this->validTerm . '/courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.1');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['collection'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }

    public function testCoursesShow_returns_json_content_for_version_one()
    {
        $data = $this->call('GET', '/terms/'.$this->validTerm.'/courses/'.$this->validClassId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }

    public function testCoursesShow_returns_json_content_for_version_one_point_one()
    {
        $data = $this->call('GET', '/api/1.1/terms/'.$this->validTerm.'/courses/'. $this->validClassId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['version'], '1.1');
        $this->assertEquals($content['collection'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }
}