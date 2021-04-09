<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HorseInRaceRepository::class)
 * @ORM\Table(name="horse_in_race")
 */
class HorseInRace
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float")
     */
    private float $timeSpent;

    /**
     * @ORM\Column(type="float")
     */
    private float $distanceCovered;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Horse")
     * @ORM\JoinColumn(nullable=false)
     */
    private Horse $horse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Race")
     * @ORM\JoinColumn(nullable=false)
     */
    private Race $race;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTimeSpent(): float
    {
        return $this->timeSpent;
    }

    public function setTimeSpent(float $timeSpent): void
    {
        $this->timeSpent = $timeSpent;
    }

    public function getDistanceCovered(): float
    {
        return $this->distanceCovered;
    }

    public function setDistanceCovered(float $distanceCovered): void
    {
        $this->distanceCovered = $distanceCovered;
    }

    public function getHorse(): Horse
    {
        return $this->horse;
    }

    public function setHorse(Horse $horse): void
    {
        $this->horse = $horse;
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function setRace(Race $race): void
    {
        $this->race = $race;
    }
}
