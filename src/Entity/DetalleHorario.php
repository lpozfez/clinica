<?php

namespace App\Entity;

use App\Repository\DetalleHorarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleHorarioRepository::class)]
class DetalleHorario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $diaSemana = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaManIni = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaManFin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaTarIni = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaTarFin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiaSemana(): ?string
    {
        return $this->diaSemana;
    }

    public function setDiaSemana(string $diaSemana): static
    {
        $this->diaSemana = $diaSemana;

        return $this;
    }

    public function getHoraManIni(): ?\DateTimeInterface
    {
        return $this->horaManIni;
    }

    public function setHoraManIni(\DateTimeInterface $horaManIni): static
    {
        $this->horaManIni = $horaManIni;

        return $this;
    }

    public function getHoraManFin(): ?\DateTimeInterface
    {
        return $this->horaManFin;
    }

    public function setHoraManFin(\DateTimeInterface $horaManFin): static
    {
        $this->horaManFin = $horaManFin;

        return $this;
    }

    public function getHoraTarIni(): ?\DateTimeInterface
    {
        return $this->horaTarIni;
    }

    public function setHoraTarIni(\DateTimeInterface $horaTarIni): static
    {
        $this->horaTarIni = $horaTarIni;

        return $this;
    }

    public function getHoraTarFin(): ?\DateTimeInterface
    {
        return $this->horaTarFin;
    }

    public function setHoraTarFin(\DateTimeInterface $horaTarFin): static
    {
        $this->horaTarFin = $horaTarFin;

        return $this;
    }
}
