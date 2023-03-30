<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreatmentRepository::class)]
class Treatment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pacient_name = null;

    #[ORM\Column]
    private ?int $pacient_id = null;

    #[ORM\Column(length: 255)]
    private ?string $age = null;

    #[ORM\Column(length: 255)]
    private ?string $medical_conditions = null;

    #[ORM\Column(length: 255)]
    private ?string $diagnostic = null;

    #[ORM\Column(length: 1500)]
    private ?string $treatment = null;

    #[ORM\Column(length: 255)]
    private ?string $recommended_by = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?int $assistant_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPacientName(): ?string
    {
        return $this->pacient_name;
    }

    public function setPacientName(string $pacient_name): self
    {
        $this->pacient_name = $pacient_name;

        return $this;
    }

    public function getPacientId(): ?int
    {
        return $this->pacient_id;
    }

    public function setPacientId(int $pacient_id): self
    {
        $this->pacient_id = $pacient_id;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getMedicalConditions(): ?string
    {
        return $this->medical_conditions;
    }

    public function setMedicalConditions(string $medical_conditions): self
    {
        $this->medical_conditions = $medical_conditions;

        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(string $diagnostic): self
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    public function getTreatment(): ?string
    {
        return $this->treatment;
    }

    public function setTreatment(string $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }

    public function getRecommendedBy(): ?string
    {
        return $this->recommended_by;
    }

    public function setRecommendedBy(string $recommended_by): self
    {
        $this->recommended_by = $recommended_by;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAssistantId(): ?int
    {
        return $this->assistant_id;
    }

    public function setAssistantId(int $assistant_id): self
    {
        $this->assistant_id = $assistant_id;

        return $this;
    }
}
