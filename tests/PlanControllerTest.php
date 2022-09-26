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

class PlanControllerTest extends TestCase
{
    protected $planId;
    public function setUp(){
        parent::setUp();
        $this->planId = '561208M';
    }

    public function testGraduateIndex_shows_plan(){
        $data = $this->call('GET', 'api/2.0/plans/graduate');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['collection'], 'plans');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }
      
    public function testShow_shows_plan(){
        $data = $this->call('GET', 'api/2.0/plans/' . $this->planId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['collection'], 'plan');
        $this->assertEquals(($content['plan']['plan_id']), $this->planId);
    }
        
    public function testGraduateIndex_shows_legacy_plan(){
        $data = $this->call('GET', 'api/plans/graduate');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'plans');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }

    public function testShow_shows_legacy_plan(){
        $data = $this->call('GET', 'api/plans/' . $this->planId);
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['success'], 'true');
        $this->assertEquals($content['type'], 'plans');
        $this->assertEquals(($content['plans']['plan_id']), $this->planId);
    }

    public function testIndex_returns_json_content_for_version_one()
    {   $data = $this->call('GET','api/plans');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['version'], '1.0');
        $this->assertEquals($content['collection'], 'plans');
//        $this->assertEquals($content['limit'], '150');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }

    public function testIndex_returns_json_content_for_version_one_point_one()
    {   $data = $this->call('GET','/api/2.0/plans');
        $content = json_decode($data->getContent(), true);
        $this->assertEquals($content['api'], 'curriculum');
        $this->assertEquals($content['status'], '200');
        $this->assertEquals($content['version'], '2.0');
        $this->assertEquals($content['collection'], 'plans');
//        $this->assertEquals($content['limit'], '150');
        $this->assertEquals(count($content['plans']), count($content['plans']));
    }
}

