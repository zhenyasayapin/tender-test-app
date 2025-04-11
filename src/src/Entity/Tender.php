<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

#[ORM\Entity]
class Tender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[NotBlank, Positive]
    private int $externalCode;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    #[NotBlank, Length(max: 50)]
    private string $number;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    #[NotBlank, Length(max: 100)]
    private string $status;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[NotBlank, Length(max: 255)]
    private string $name;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTimeInterface $date;

    public function __construct() {
        $this->date = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExternalCode(): int
    {
        return $this->externalCode;
    }

    public function setExternalCode(int $externalCode): self
    {
        $this->externalCode = $externalCode;
        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->date = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->date = new \DateTimeImmutable();
    }
}