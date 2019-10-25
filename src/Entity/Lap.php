<?php


namespace App\Entity;


use Carbon\{Carbon, CarbonInterface};

class Lap
{
    /**
     * @var int
     */
    private $number;

    /**
     * @var CarbonInterface
     */
    private $time;

    /**
     * @var CarbonInterface
     */
    private $duration;

    /**
     * @var float
     */
    private $speed;

    /**
     * @var ?Pilot
     */
    private $pilot;

    public function __construct()
    {
        $this->time = Carbon::create(0,0,0,0,0,0);
        $this->duration = Carbon::create(0,0,0,0,0,0);
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Lap
     */
    public function setNumber(int $number): Lap
    {
        $this->number = $number;
        return $this;
    }


    /**
     * @return CarbonInterface
     */
    public function getTime(): CarbonInterface
    {
        return $this->time;
    }

    /**
     * @param CarbonInterface $time
     * @return Lap
     */
    public function setTime(CarbonInterface $time): Lap
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return CarbonInterface
     */
    public function getDuration(): CarbonInterface
    {
        return $this->duration;
    }

    /**
     * @param CarbonInterface $duration
     * @return Lap
     */
    public function setDuration(CarbonInterface $duration): Lap
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return float
     */
    public function getSpeed(): float
    {
        return $this->speed;
    }

    /**
     * @param float $speed
     * @return Lap
     */
    public function setSpeed(float $speed): Lap
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return Pilot|null
     */
    public function getPilot(): ?Pilot
    {
        return $this->pilot;
    }

    /**
     * @param mixed $pilot
     * @return Lap
     */
    public function setPilot($pilot)
    {
        $this->pilot = $pilot;
        return $this;
    }
}
