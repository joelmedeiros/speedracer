<?php


namespace App\Service;


use App\Entity;
use App\Repository;
use Carbon\Carbon;

class Race
{
    /**
     * @var Repository\Pilot
     */
    private $pilotRepository;

    /**
     * @var Repository\Lap
     */
    private $lapRepository;

    /**
     * @var \ArrayObject
     */
    private $grid;

    public function __construct(array $data)
    {
        $this->pilotRepository = new Repository\Pilot();
        $this->lapRepository = new Repository\Lap();
        $this->setGrid($data);
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        $grid = $this->getGridSortedByArrivals();

        $result = [];
        $position = 1;
        $iterator = $grid->getIterator();
        while ($iterator->valid()) {
            /** @var Entity\Lap $lap */
            $lap = $iterator->current();
            /** @var Entity\Pilot $pilot */
            $pilot = $lap->getPilot();
            $result[] = array_merge(["position" => $position], $pilot->toArray());

            $position++;
            $iterator->next();
        }

        return $result;
    }

    /**
     * @param array $data
     */
    private function setGrid(array $data): void
    {
        $this->grid = new \ArrayObject();

        foreach ($data as $pilotId => $laps) {
            list($pilotId, $name) = preg_split(
                "/[^\w.]+/",
                $laps[0][1],
                -1,
                PREG_SPLIT_DELIM_CAPTURE
            );

            /** @var Entity\Pilot $pilot */
            $pilot = $this->pilotRepository->create($pilotId, $name);

            foreach ($laps as $data) {
                $data = $this->hydrateLap(...$data);

                /** @var Entity\Lap $lap */
                $lap = $this->lapRepository->create(...$data);

                /** @var Entity\Pilot $pilot */
                $this->pilotRepository->addLap($pilot, $lap);
            }

            $this->grid->append($pilot);
        }
    }

    /**
     * @param \ArrayObject $grid
     * @return \ArrayObject
     */
    private function getGridSortedByArrivals(): \ArrayObject
    {
        $gridSortedByArrivals = new \ArrayObject();

        /** @var Entity\Pilot $pilot */
        foreach ($this->grid as $pilot) {
            // I did not find the best place to do this
            $pilot
                ->processTotalTime()
                ->processAvgSpeed();

            $gridSortedByArrivals->append($pilot->getLastLap());
        }

        // sorting arrival order
        $gridSortedByArrivals->uasort(function (Entity\Lap $a, Entity\Lap $b) {
            return $a->getNumber() >= $b->getNumber() && $a->getTime() > $b->getTime();
        });

        return $gridSortedByArrivals;
    }

    /**
     * @param $time
     * @param $pilot
     * @param $number
     * @param $duration
     * @param $speed
     * @return array
     */
    private function hydrateLap($time, $pilot, $number, $duration, $speed): array
    {
        $time = Carbon::createFromFormat('H:i:s.u', $time);
        $pieces = explode(':', $duration);
        $minute = $pieces[0];

        if (strlen($minute) <= 1) {
            $pieces[0] = "0{$minute}";
            $duration = implode(":", $pieces);
        }

        $duration = Carbon::createFromFormat('i:s.u', $duration);
        $speed = round(str_replace(',', '.', $speed), 3);

        return [$time, $number, $duration, $speed];
    }
}