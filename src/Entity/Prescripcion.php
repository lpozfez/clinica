<?php

namespace App\Entity;

use App\Repository\PrescripcionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrescripcionRepository::class)]
class Prescripcion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $medicamento = null;

    #[ORM\Column(length: 255)]
    private ?string $posologia = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $suspension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motivo = null;

    #[ORM\ManyToOne(inversedBy: 'medicacion')]
    private ?Paciente $paciente = null;

    #[ORM\OneToMany(mappedBy: 'prescripcion', targetEntity: Renovacion::class)]
    private Collection $renovaciones;

    public function __construct()
    {
        $this->renovaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getMedicamento(): ?string
    {
        return $this->medicamento;
    }

    public function setMedicamento(string $medicamento): static
    {
        $this->medicamento = $medicamento;

        return $this;
    }

    public function getPosologia(): ?string
    {
        return $this->posologia;
    }

    public function setPosologia(string $posologia): static
    {
        $this->posologia = $posologia;

        return $this;
    }

    public function getSuspension(): ?\DateTimeInterface
    {
        return $this->suspension;
    }

    public function setSuspension(?\DateTimeInterface $suspension): static
    {
        $this->suspension = $suspension;

        return $this;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(?string $motivo): static
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): static
    {
        $this->paciente = $paciente;

        return $this;
    }

    public function toArray() 
    { 
        return [ 
            'id' => $this->getId(), 
            'fecha'=>$this->getFecha(),
            'medicamento'=>$this->getMedicamento(),
            'posologia'=>$this->getPosologia(),
            'suspension'=>$this->getSuspension(),
            'motivo'=>$this->getMotivo(),
            'paciente'=>$this->getPaciente()->toArray()
        ]; 
    }

    public function __toString(): string
    {
        return $this->fecha.'-'.$this->medicamento;
    }

    /**
     * @return Collection<int, Renovacion>
     */
    public function getRenovaciones(): Collection
    {
        return $this->renovaciones;
    }

    public function addRenovacione(Renovacion $renovacione): static
    {
        if (!$this->renovaciones->contains($renovacione)) {
            $this->renovaciones->add($renovacione);
            $renovacione->setPrescripcion($this);
        }

        return $this;
    }

    public function removeRenovacione(Renovacion $renovacione): static
    {
        if ($this->renovaciones->removeElement($renovacione)) {
            // set the owning side to null (unless already changed)
            if ($renovacione->getPrescripcion() === $this) {
                $renovacione->setPrescripcion(null);
            }
        }

        return $this;
    }
}
