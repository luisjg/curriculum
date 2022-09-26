<?php
/*  Curriculum Web Service - Backend that delivers CSUN class and course information.
 *  Copyright (C) 2014-2019 - CSUN META+LAB
 *
 *  Waldo Web Service is free software: you can redistribute it and/or modify it under the terms
 *  of the GNU General Public License as published by the Free Software Found-
 *  ation, either version 3 of the License, or (at your option) any later version.
 *
 *  RetroArch is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *  PURPOSE.  See the GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along with RetroArch.
 *  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tests;

class TermControllerTest extends TestCase
{

    protected $validEmail;
    protected $validTerm;
    protected $validClassId;
    protected $validClassId2;

    public function setUp(){
        parent::setUp();
        $this->validEmail = 'nr_nerces.kazandjian@csun.edu';
        $this->validTerm = 2153;
        $this->validClassId = 19149;
        $this->validClassId2 = 'comp-100';
    }

    public function testClassesShow_shows_classes(){
        $data = $this->call('GET', 'api/2.0/terms/Spring-2015/classes/' . $this->validClassId2);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'2.0');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }
    public function testClassesShow_shows_legacy_classes(){
        $data = $this->call('GET', 'api/terms/Spring-2015/classes/' . $this->validClassId2);
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
        $data = $this->call('GET','api/terms/' . $this->validTerm . '/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }

    public function testClassesIndex_returns_json_content_for_version_two()
    {
        $data = $this->call('GET','api/2.0/terms/' . $this->validTerm . '/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['collection'], 'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }

    public function testCoursesIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET','api/terms/' . $this->validTerm . '/courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }

    public function testCoursesIndex_returns_json_content_for_version_two()
    {
        $data = $this->call('GET','api/2.0/terms/' . $this->validTerm . '/courses');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['collection'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }

    public function testCoursesShow_returns_json_content_for_version_one()
    {
        $data = $this->call('GET', 'api/terms/'.$this->validTerm.'/courses/'.$this->validClassId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }

    public function testCoursesShow_returns_json_content_for_version_two()
    {
        $data = $this->call('GET', '/api/2.0/terms/'.$this->validTerm.'/courses/'. $this->validClassId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], 200);
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['collection'], 'courses');
        $this->assertEquals(count($content['courses']), count($content['courses']));
    }
}