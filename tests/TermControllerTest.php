<?php
use Curriculum\Http\Controllers\TermController;

class TermControllerTest extends TestCase {

    protected $validEmail = 'steven.fitzgerald@csun.edu';

    public function setUp(){
        parent::setUp();
    }

    public function testClassesIndex_returns_json_content(){
        $data = $this->call('GET','/terms/2153/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals(count($content['classes']), 2);
    }



}

