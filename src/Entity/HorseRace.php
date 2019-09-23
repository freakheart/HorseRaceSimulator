<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="horse_race")
 * Class HorseRace
 * @package App\Entity
 */
Class HorseRace
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Horse
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Horse")
     * @ORM\JoinColumn(nullable=false)
     */
    private $horse;

    /**
     * @var Race
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Race")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $timeSpent;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $distanceCovered;

    public function getId(): int {
        return $this->id;
    }

    public function setHorse(Horse $horse): void {
        $this->horse = $horse;
    }

    public function getHorse(): Horse {
        return $this->horse;
    }

    public function setRace(Race $race): void {
        $this->race = $race;
    }

    public function getRace(): Race {
        return $this->race;
    }

    public function setTimeSpent(float $timeSpent): void {
        $this->timeSpent = $timeSpent;
    }

    public function getTimeSpent(): float {
        return $this->timeSpent;
    }

    public function setDistanceCovered(float $distanceCovered): void {
        $this->distanceCovered = $distanceCovered;
    }

    public function getDistanceCovered(): float {
        return $this->distanceCovered;
    }
}