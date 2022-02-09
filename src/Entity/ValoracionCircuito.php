<?php

namespace App\Entity;

use App\Repository\ValoracionCircuitoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValoracionCircuitoRepository::class)
 */
class ValoracionCircuito
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
     * @ORM\OneToOne(targetEntity=Reserva::class, inversedBy="valoracionCircuito", cascade={"persist", "remove"})
     */
    private $reserva;

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
