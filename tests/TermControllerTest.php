<?php
use Curriculum\Http\Controllers\TermController;

class TermControllerTest extends TestCase {

    protected $termController;

    public function setUp(){
        $this->termController = new TermController;
    }

    public function testClassesIndex_returns_json_content(){
        $data = $this->call('GET','/terms/2153/classes?instructor=steven.fitzgerald@csun.edu');
        $this->asserEquals($data['version'], '1.0');
    }

}

