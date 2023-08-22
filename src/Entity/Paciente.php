<?php

namespace App\Entity;

use App\Repository\PacienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'consulta')]
    private ?SeguroMedico $seguro = null;

    #[ORM\OneToMany(mappedBy: 'paciente', targetEntity: Consulta::class)]
    private Collection $consulta;

    #[ORM\OneToMany(mappedBy: 'paciente', targetEntity: Prescripcion::class)]
    private Collection $medicacion;

    public function __construct()
    {
        $this->consulta = new ArrayCollection();
        $this->medicacion = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSeguro(): ?SeguroMedico
    {
        return $this->seguro;
    }

    public function setSeguro(?SeguroMedico $seguro): static
    {
        $this->seguro = $seguro;

        return $this;
    }

    /**
     * @return Collection<int, Consulta>
     */
    public function getConsulta(): Collection
    {
        return $this->consulta;
    }

    public function addConsultum(Consulta $consultum): static
    {
        if (!$this->consulta->contains($consultum)) {
            $this->consulta->add($consultum);
            $consultum->setPaciente($this);
        }

        return $this;
    }

    public function removeConsultum(Consulta $consultum): static
    {
        if ($this->consulta->removeElement($consultum)) {
            // set the owning side to null (unless already changed)
            if ($consultum->getPaciente() === $this) {
                $consultum->setPaciente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prescripcion>
     */
    public function getMedicacion(): Collection
    {
        return $this->medicacion;
    }

    public function addMedicacion(Prescripcion $medicacion): static
    {
        if (!$this->medicacion->contains($medicacion)) {
            $this->medicacion->add($medicacion);
            $medicacion->setPaciente($this);
        }

        return $this;
    }

    public function removeMedicacion(Prescripcion $medicacion): static
    {
        if ($this->medicacion->removeElement($medicacion)) {
            // set the owning side to null (unless already changed)
            if ($medicacion->getPaciente() === $this) {
                $medicacion->setPaciente(null);
            }
        }

        return $this;
    }

    public function toArray() 
    { 
        if($this->getSeguro()!=null){
            return [ 
                'id' => $this->getId(), 
                'nombre' =>$this->getNombre(),
                'ap1' =>$this->getAp1(),
                'ap2' =>$this->getAp2(),
                'dni' =>$this->getDni(),
                'tarjeta' =>$this->getTarjeta(),
                'foto' =>$this->getFoto(),
                'seguro'=>$this->getSeguro()->toArray(),
                'user'=>$this->getUser()->toArray()
            ];
        }else{
            return [ 
                'id' => $this->getId(), 
                'nombre' =>$this->getNombre(),
                'ap1' =>$this->getAp1(),
                'ap2' =>$this->getAp2(),
                'dni' =>$this->getDni(),
                'tarjeta' =>$this->getTarjeta(),
                'foto' =>$this->getFoto(),
                'seguro'=>null,
                'user'=>$this->getUser()->toArray()
            ];
        }
    }

    public function __toString(): string
    {
        return $this->ap1." ".$this->ap2." ,".$this->nombre;
    }
}
