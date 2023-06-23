<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultaRepository::class)]
class Consulta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notasClinicas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotasClinicas(): ?string
    {
        return $this->notasClinicas;
    }

    public function setNotasClinicas(?string $notasClinicas): static
    {
        $this->notasClinicas = $notasClinicas;

        return $this;
    }
}
