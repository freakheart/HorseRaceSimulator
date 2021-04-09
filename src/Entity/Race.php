<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RaceRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RaceRepository::class)
 * @ORM\Table(name="race")
 */
class Race
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $active;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $completedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $duration;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $maxDistance;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?DateTimeImmutable $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): void
    {
        $this->duration = $duration;
    }

    public function getMaxDistance(): ?float
    {
        return $this->maxDistance;
    }

    public function setMaxDistance(?float $maxDistance): void
    {
        $this->maxDistance = $maxDistance;
    }
}
