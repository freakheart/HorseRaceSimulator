<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HorseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HorseRepository::class)
 * @ORM\Table(name="horse")
 */
class Horse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0.0,
     *      max = 10.0,
     *      minMessage = "Minimum speed of the horse must be greater than or equal to {{ limit }} m/s",
     *      maxMessage = "Maximum speed of the horse must be less than or equal to {{ limit }} m/s"
     * )
     */
    private float $speed;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0.0,
     *      max = 10.0,
     *      minMessage = "Minimum strength of the horse must be greather than or equal to {{ limit }} m/s",
     *      maxMessage = "Maximum strength of the horse must be less or equal than {{ limit }} m/s"
     * )
     */
    private float $strength;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0.0,
     *      max = 10.0,
     *      minMessage = "Minimum endurance of the horse must be greather tthan or equal to {{ limit }} m/s",
     *      maxMessage = "Maximum endurance of the horse must be less than or equal to {{ limit }} m/s"
     * )
     */
    private float $endurance;

    /**
     * @ORM\Column(type="float")
     */
    private float $bestSpeed;

    /**
     * @ORM\Column(type="float")
     */
    private float $autonomy;

    /**
     * @ORM\Column(type="float")
     */
    private float $slowDown;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setSpeed(float $speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return float
     */
    public function getStrength(): float
    {
        return $this->strength;
    }

    /**
     * @param float $strength
     */
    public function setStrength(float $strength): void
    {
        $this->strength = $strength;
    }

    /**
     * @return float
     */
    public function getEndurance(): float
    {
        return $this->endurance;
    }

    /**
     * @param float $endurance
     */
    public function setEndurance(float $endurance): void
    {
        $this->endurance = $endurance;
    }

    /**
     * @return float
     */
    public function getBestSpeed(): float
    {
        return $this->bestSpeed;
    }

    /**
     * @param float $bestSpeed
     */
    public function setBestSpeed(float $bestSpeed): void
    {
        $this->bestSpeed = $bestSpeed;
    }

    /**
     * @return float
     */
    public function getAutonomy(): float
    {
        return $this->autonomy;
    }

    /**
     * @param float $autonomy
     */
    public function setAutonomy(float $autonomy): void
    {
        $this->autonomy = $autonomy;
    }

    /**
     * @return float
     */
    public function getSlowDown(): float
    {
        return $this->slowDown;
    }

    /**
     * @param float $slowDown
     */
    public function setSlowDown(float $slowDown): void
    {
        $this->slowDown = $slowDown;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
