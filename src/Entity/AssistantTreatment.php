<?php

namespace App\Entity;

use App\Repository\AssistantTreatmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssistantTreatmentRepository::class)]
class AssistantTreatment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pacient_id = null;

    #[ORM\Column]
    private ?int $assistant_id = null;

    #[ORM\Column(length: 4000)]
    private ?string $treatment_applied = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAssistantId(): ?int
    {
        return $this->assistant_id;
    }

    public function setAssistantId(int $assistant_id): self
    {
        $this->assistant_id = $assistant_id;

        return $this;
    }

    public function getTreatmentApplied(): ?string
    {
        return $this->treatment_applied;
    }

    public function setTreatmentApplied(string $treatment_applied): self
    {
        $this->treatment_applied = $treatment_applied;

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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
