<?php

namespace App\Entity;

use DateTime;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ReservaRepository::class)
 */
class Reserva implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="float")
     */
    private $precio=50;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="reservas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\OneToOne(targetEntity=ValoracionCircuito::class, mappedBy="reserva", cascade={"persist", "remove"})
     */
    private $valoracionCircuito;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_inicio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_fin;

    /**
     * @ORM\OneToMany(targetEntity=DetalleReserva::class, mappedBy="reserva")
     */
    private $detalleReservas;

    public function __construct()
    {
        // $date = new DateTime();
        $this->fecha = new DateTime();
        $this->detalleReservas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getValoracionCircuito(): ?ValoracionCircuito
    {
        return $this->valoracionCircuito;
    }

    public function setValoracionCircuito(?ValoracionCircuito $valoracionCircuito): self
    {
        // unset the owning side of the relation if necessary
        if ($valoracionCircuito === null && $this->valoracionCircuito !== null) {
            $this->valoracionCircuito->setReserva(null);
        }

        // set the owning side of the relation if necessary
        if ($valoracionCircuito !== null && $valoracionCircuito->getReserva() !== $this) {
            $valoracionCircuito->setReserva($this);
        }

        $this->valoracionCircuito = $valoracionCircuito;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(?\DateTimeInterface $fecha_fin): self
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    /**
     * @return Collection|DetalleReserva[]
     */
    public function getDetalleReservas(): Collection
    {
        return $this->detalleReservas;
    }

    public function addDetalleReserva(DetalleReserva $detalleReserva): self
    {
        if (!$this->detalleReservas->contains($detalleReserva)) {
            $this->detalleReservas[] = $detalleReserva;
            $detalleReserva->setReserva($this);
        }

        return $this;
    }

    public function removeDetalleReserva(DetalleReserva $detalleReserva): self
    {
        if ($this->detalleReservas->removeElement($detalleReserva)) {
            // set the owning side to null (unless already changed)
            if ($detalleReserva->getReserva() === $this) {
                $detalleReserva->setReserva(null);
            }
        }

        return $this;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
