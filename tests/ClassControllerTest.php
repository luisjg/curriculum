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

class ClassControllerTest extends TestCase
{
    protected $classController;
    protected $classId = 'comp-100';
    protected $validEmail = 'nr_nerces.kazandjian@csun.edu';
    public function setUp(){
        parent::setUp();
    }
    public function testShow_shows_class(){
        $data = $this->call('GET', 'api/2.0/classes/15015');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'2.0');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }
    public function testShow_shows_legacy_class(){
        $data = $this->call('GET', 'api/classes/15015');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['type'],'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }
  
   public function testIndex_returns_json_content_for_version_one()
    {
        $data = $this->call('GET', 'api/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'],'1.0');
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['type'],'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }

    public function testIndex_returns_json_content_for_version_two()
    {
        $data = $this->call('GET', 'api/2.0/classes?instructor='.$this->validEmail);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'],'curriculum');
        $this->assertEquals($content['status'],'200');
        $this->assertEquals($content['success'],'true');
        $this->assertEquals($content['version'],'2.0');
        $this->assertEquals($content['collection'],'classes');
        $this->assertEquals(count($content['classes']), count($content['classes']));
    }
}
