<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="horse")
 * Defines the properties of the Horse entity.
 *
 * Class Horse
 */
class Horse
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0.0,
     *      max = 10.0,
     *      minMessage = "Minimum speed of the horse must be greater than or equal to {{ limit }} m/s",
     *      maxMessage = "Maximum speed of the horse must be less than or equal to {{ limit }} m/s"
     * )
     */
    private $speed;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0.0,
     *      max = 10.0,
     *      minMessage = "Minimum strength of the horse must be greather than or equal to {{ limit }} m/s",
     *      maxMessage = "Maximum strength of the horse must be less or equal than {{ limit }} m/s"
     * )
     */
    private $strength;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0.0,
     *      max = 10.0,
     *      minMessage = "Minimum endurance of the horse must be greather tthan or equal to {{ limit }} m/s",
     *      maxMessage = "Maximum endurance of the horse must be less than or equal to {{ limit }} m/s"
     * )
     */
    private $endurance;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $bestSpeed;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $autonomy;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $slowDown;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function setSpeed(float $speed): void
    {
        $this->speed = $speed;
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }

    public function setStrength(float $strength): void
    {
        $this->strength = $strength;
    }

    public function getStrength(): float
    {
        return $this->strength;
    }

    public function setEndurance(float $endurance): void
    {
        $this->endurance = $endurance;
    }

    public function getEndurance(): float
    {
        return $this->endurance;
    }

    public function setBestSpeed(float $bestSpeed): void
    {
        $this->bestSpeed = $bestSpeed;
    }

    public function getBestSpeed(): float
    {
        return $this->bestSpeed;
    }

    public function getAutonomy(): ?float
    {
        return $this->autonomy;
    }

    public function setAutonomy(float $autonomy): void
    {
        $this->autonomy = $autonomy;
    }

    public function setSlowDown(float $slowDown): void
    {
        $this->slowDown = $slowDown;
    }

    public function getSlowDown(): ?float
    {
        return $this->slowDown;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
