<?php

namespace App\Entity;

use App\Repository\SeguroMedicoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeguroMedicoRepository::class)]
class SeguroMedico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'seguro', targetEntity: Paciente::class)]
    private Collection $pacientes;

    public function __construct()
    {
        $this->pacientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Paciente>
     */
    public function getPacientes(): Collection
    {
        return $this->pacientes;
    }

    public function addConsultum(Paciente $consultum): static
    {
        if (!$this->pacientes->contains($consultum)) {
            $this->pacientes->add($consultum);
            $consultum->setSeguro($this);
        }

        return $this;
    }

    public function removeConsultum(Paciente $consultum): static
    {
        if ($this->pacientes->removeElement($consultum)) {
            // set the owning side to null (unless already changed)
            if ($consultum->getSeguro() === $this) {
                $consultum->setSeguro(null);
            }
        }

        return $this;
    }
}
