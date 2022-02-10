<?php

namespace App\Entity;

use App\Repository\DetalleReservaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetalleReservaRepository::class)
 */
class DetalleReserva
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Coche::class, inversedBy="detalleReservas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coche;

    /**
     * @ORM\OneToOne(targetEntity=ValoracionCoche::class, mappedBy="detalle_reserva", cascade={"persist", "remove"})
     */
    private $valoracionCoche;

    /**
     * @ORM\ManyToOne(targetEntity=Reserva::class, inversedBy="detalleReservas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reserva;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoche(): ?Coche
    {
        return $this->coche;
    }

    public function setCoche(?Coche $coche): self
    {
        $this->coche = $coche;

        return $this;
    }

    public function getValoracionCoche(): ?ValoracionCoche
    {
        return $this->valoracionCoche;
    }

    public function setValoracionCoche(?ValoracionCoche $valoracionCoche): self
    {
        // unset the owning side of the relation if necessary
        if ($valoracionCoche === null && $this->valoracionCoche !== null) {
            $this->valoracionCoche->setDetalleReserva(null);
        }

        // set the owning side of the relation if necessary
        if ($valoracionCoche !== null && $valoracionCoche->getDetalleReserva() !== $this) {
            $valoracionCoche->setDetalleReserva($this);
        }

        $this->valoracionCoche = $valoracionCoche;

        return $this;
    }

    public function getReserva(): ?Reserva
    {
        return $this->reserva;
    }

    public function setReserva(?Reserva $reserva): self
    {
        $this->reserva = $reserva;

        return $this;
    }
}
