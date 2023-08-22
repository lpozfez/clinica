<?php

namespace App\Entity;

use App\Repository\RenovacionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenovacionRepository::class)]
class Renovacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'renovaciones')]
    private ?Prescripcion $prescripcion = null;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrescripcion(): ?Prescripcion
    {
        return $this->prescripcion;
    }

    public function setPrescripcion(?Prescripcion $prescripcion): static
    {
        $this->prescripcion = $prescripcion;

        return $this;
    }

    public function toArray() 
    { 
        return [ 
            'id' => $this->getId(), 
            'fecha'=>$this->getFecha(),
            'descripcion'=>$this->getDescripcion(),
            'prescripcion'=>$this->getPrescripcion()->toArray()
        ]; 
    }

    public function __toString(): string
    {
        return $this->fecha.'-'.$this->descripcion;
    }

}
