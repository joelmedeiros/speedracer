<?php


namespace App\Repository;

use App\Entity;
use Carbon\CarbonInterface;

class Lap
{
    public function create(CarbonInterface $time, int $number, CarbonInterface $duration, float $speed): Entity\Lap
    {
        $lap = new Entity\Lap();
        $lap
            ->setNumber($number)
            ->setTime($time)
            ->setDuration($duration)
            ->setSpeed($speed);

        return $lap;
    }
}
