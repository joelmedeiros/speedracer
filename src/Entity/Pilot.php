<?php


namespace App\Entity;


use Carbon\{Carbon,CarbonInterface};

class Pilot
{
    /**
     * @var string $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var \ArrayObject
     */
    private $laps;

    /**
     * @var float
     */
    private $avgSpeed = 0.00;

    /**
     * @var CarbonInterface
     */
    private $totalTime;

    public function __construct()
    {
        $this->laps = new \ArrayObject([], \ArrayObject::STD_PROP_LIST);
        $this->totalTime = Carbon::create(0,0,0,0,0,0);
    }

    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "laps" => $this->getLaps()->count(),
            "total_time" => $this->getTotalTime()->format('H:i:s.u'),
            "avg_speed" => $this->getAvgSpeed()
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): Pilot
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): Pilot
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Lap $lap
     * @return self
     */
    public function addLap(Lap $lap): Pilot
    {
        $this->laps->append($lap);
        $lap->setPilot($this);
        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getLaps()
    {
        return $this->laps;
    }

    /**
     * @return float
     */
    public function getAvgSpeed(): float
    {
        return $this->avgSpeed;
    }

    /**
     * @param float $avgSpeed
     * @return self
     */
    public function setAvgSpeed(float $avgSpeed): Pilot
    {
        $this->avgSpeed = $avgSpeed;
        return $this;
    }

    /**
     * @return CarbonInterface
     */
    public function getTotalTime(): CarbonInterface
    {
        return $this->totalTime;
    }

    /**
     * @param CarbonInterface $totalTime
     * @return self
     */
    public function setTotalTime(CarbonInterface $totalTime): Pilot
    {
        $this->totalTime = $totalTime;
        return $this;
    }

    /**
     * @return $this
     */
    public function processAvgSpeed(): self
    {
        $sum = 0;
        foreach ($this->getLaps()->getIterator() as $lap) {
            $sum += $lap->getSpeed();
        }

        $this->setAvgSpeed(round($sum/$this->getLaps()->count(), 3));
        return $this;
    }

    /**
     * @return self
     */
    public function processTotalTime(): self
    {
        foreach ($this->getLaps() as $lap) {
            $this->getTotalTime()
                ->addRealMinutes($lap->getDuration()->format('i'))
                ->addRealSeconds($lap->getDuration()->format('s'))
                ->addRealMicroseconds($lap->getDuration()->format('u'));
        }

        return $this;
    }

    /**
     * @return Lap
     */
    public function getLastLap(): Lap
    {
        $this->getLaps()->uasort(function(Lap $a, Lap $b) {
            return $a->getNumber() < $b->getNumber();
        });

        return $this->getLaps()->getIterator()->current();
    }
}
