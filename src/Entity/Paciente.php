<?php

namespace App\Entity;

use App\Repository\PacienteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PacienteRepository::class)]
class Paciente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $ap1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ap2 = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $tarjeta = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

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

    public function getAp1(): ?string
    {
        return $this->ap1;
    }

    public function setAp1(string $ap1): static
    {
        $this->ap1 = $ap1;

        return $this;
    }

    public function getAp2(): ?string
    {
        return $this->ap2;
    }

    public function setAp2(?string $ap2): static
    {
        $this->ap2 = $ap2;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getTarjeta(): ?string
    {
        return $this->tarjeta;
    }

    public function setTarjeta(?string $tarjeta): static
    {
        $this->tarjeta = $tarjeta;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }
}
