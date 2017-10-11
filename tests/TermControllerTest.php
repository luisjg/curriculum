<?php
use Curriculum\Http\Controllers\TermController;

class TermControllerTest extends TestCase {

    protected $validEmail = 'steven.fitzgerald@csun.edu';

    public function setUp(){
        parent::setUp();
    }

    public function testClassesIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET','/terms/2153/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals(count($content['classes']), 2);
    }

    public function testClassesIndex_returns_json_content_for_version_one_point_one()
    {
        $data = $this->call('GET','api/1.1/terms/2153/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.1');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['collection'], 'classes');
        $this->assertEquals(count($content['classes']), 2);
    }

    public function testCoursesIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET','/terms/2153/courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'courses');
        $this->assertEquals(count($content['courses']), 2878);
    }

    public function testCoursesIndex_returns_json_content_for_version_one_point_one()
    {
        $data = $this->call('GET','api/1.1/terms/2153/courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.1');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['collection'], 'courses');
        $this->assertEquals(count($content['courses']), 2878);
    }
}

