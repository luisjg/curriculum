<?php
use Curriculum\Http\Controllers\TermController;

class TermControllerTest extends TestCase {

    protected $validEmail;
    protected $validTerm;
    protected $validClassId;

    public function setUp(){
        parent::setUp();
        $this->validEmail = 'steven.fitzgerald@csun.edu';
        $this->validTerm = 2153;
        $this->validClassId = 19149;
    }

    public function testClassesIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET','/terms/' . $this->validTerm . '/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals(count($content['classes']), 2);
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
        $this->assertEquals(count($content['classes']), 2);
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
        $this->assertEquals(count($content['courses']), 2878);
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
        $this->assertEquals(count($content['courses']), 2878);
    }

    public function testCoursesShow_returns_json_content_for_version_one()
    {
        $data = $this->call('GET', '/terms/'.$this->validTerm.'/courses/'.$this->validClassId);

    }

}

