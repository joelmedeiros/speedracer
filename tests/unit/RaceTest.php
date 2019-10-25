<?php

namespace App\Tests;


use App\Service\FileManagement;
use App\Service\Race;

class RaceTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    /**
     * @throws \Exception
     */
    public function testGetResults()
    {
        $fileManagement = new FileManagement('tests/_data/race.log');
        $data = $fileManagement->read();

        /** @var \ArrayObject $result */
        $result = (new Race($data))->getResults();

        $this->assertEquals([
            [
                "position" => 1,
                "id" => "038",
                "name" => "F.MASSA",
                "laps" => 4,
                "total_time" => "00:04:09.787000",
                "avg_speed" => 44.246
            ],
            [
                "position" => 2,
                "id" => "002",
                "name" => "K.RAIKKONEN",
                "laps" => 4,
                "total_time" => "00:04:13.076000",
                "avg_speed" => 43.627
            ],
            [
                "position" => 3,
                "id" => "033",
                "name" => "R.BARRICHELLO",
                "laps" => 4,
                "total_time" => "00:04:15.010000",
                "avg_speed" => 43.468
            ],
            [
                "position" => 4,
                "id" => "023",
                "name" => "M.WEBBER",
                "laps" => 4,
                "total_time" => "00:04:16.216000",
                "avg_speed" => 43.191
            ],
            [
                "position" => 5,
                "id" => "015",
                "name" => "F.ALONSO",
                "laps" => 4,
                "total_time" => "00:04:53.050000",
                "avg_speed" => 38.066
            ],
            [
                "position" => 6,
                "id" => "011",
                "name" => "S.VETTEL",
                "laps" => 3,
                "total_time" => "00:06:26.097000",
                "avg_speed" => 25.746
            ]
        ], $result);
    }
}
