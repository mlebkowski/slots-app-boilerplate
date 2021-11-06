<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SlotRepository")
 */
class Slot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $dateFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $dateTo;

    /**
     * @ORM\Column(type="integer")
     */
    private int $doctorId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTimeInterface $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTimeInterface $dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    public function getDoctorId(): ?int
    {
        return $this->doctorId;
    }

    public function setDoctorId(int $doctorId): void
    {
        $this->doctorId = $doctorId;
    }
}
