<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="race")
 *
 * Class Race
 * @package App\Entity
 */
Class Race
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     *
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $completedAt;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $duration;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $maxDistance;

    public function getId(): int {
        return $this->id;
    }

    public function setActive(int $active): void {
        $this->active = $active;
    }

    public function getActive(): int {
        return $this->active;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCompletedAt(?\DateTimeImmutable $completedAt): void {
        $this->completedAt = $completedAt;
    }

    public function getCompletedAt(): ?\DateTimeImmutable {
        return $this->completedAt;
    }

    public function setDuration(?float $duration): void {
        $this->duration = $duration;
    }

    public function getDuration(): ?float {
        return $this->duration;
    }

    public function setMaxDistance(float $maxDistance): void {
        $this->maxDistance = $maxDistance;
    }

    public function getMaxDistance(): ?float {
        return $this->maxDistance;
    }

}