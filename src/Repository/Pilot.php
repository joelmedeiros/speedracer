<?php


namespace App\Repository;

use App\Entity;

class Pilot
{
    /**
     * @param string $id
     * @param string $name
     * @return Entity\Pilot
     */
    public function create(string $id, string $name): Entity\Pilot
    {
        $pilot = new Entity\Pilot();

        return $pilot->setId($id)->setName($name);
    }

    /**
     * @param Entity\Pilot $pilot
     * @param Entity\Lap $lap
     * @return self
     */
    public function addLap(Entity\Pilot $pilot, Entity\Lap $lap): self
    {
        $pilot->addLap($lap);

        return $this;
    }
}