<?php

use Curriculum\Http\Controllers\CourseController;

class CourseControllerTest extends TestCase
{
    public function setUp(){
        parent::setUp();
    }
    public function testInfo_shows_courses(){
        $data = $this->call('GET', 'api/1.1/courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'1.1');
        $this->assertEquals($content['type'],'courses');
        $this->assertArrayHasKey('courses',$content);
    }
    public function testInfo_shows_legacy_courses(){
        $data = $this->call('GET', 'courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['type'],'courses');
        $this->assertArrayHasKey('courses',$content);
    }
}
