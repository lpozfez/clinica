<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultaRepository::class)]
class Consulta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $notasClinicas = null;

    #[ORM\ManyToOne(inversedBy: 'consulta')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paciente $paciente = null;

    #[ORM\ManyToOne(inversedBy: 'consultas')]
    private ?TipoConsulta $tipo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

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

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): static
    {
        $this->paciente = $paciente;

        return $this;
    }

    public function getTipo(): ?TipoConsulta
    {
        return $this->tipo;
    }

    public function setTipo(?TipoConsulta $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function toArray()
    {

        return [
            'id' => $this->getId(),
            'tipo_consulta' => $this->getTipo()->toArray(),
            'paciente' => $this->getPaciente()->toArray(),
            'notas' => $this->getNotasClinicas(),
            'fecha'=>$this->getFecha()
        ];
    }

    public function __toString(): string
    {
        return $this->tipo." ".$this->paciente." ".$this->fecha;
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











}
