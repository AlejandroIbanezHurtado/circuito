<?php

namespace App\Entity;

use App\Repository\ValoracionCocheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValoracionCocheRepository::class)
 */
class ValoracionCoche
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $valoracion;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\OneToOne(targetEntity=DetalleReserva::class, inversedBy="valoracionCoche", cascade={"persist", "remove"})
     */
    private $detalle_reserva;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValoracion(): ?int
    {
        return $this->valoracion;
    }

    public function setValoracion(int $valoracion): self
    {
        $this->valoracion = $valoracion;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getDetalleReserva(): ?DetalleReserva
    {
        return $this->detalle_reserva;
    }

    public function setDetalleReserva(?DetalleReserva $detalle_reserva): self
    {
        $this->detalle_reserva = $detalle_reserva;

        return $this;
    }
}
