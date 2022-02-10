<?php

namespace App\Entity;

use App\Repository\CircuitoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CircuitoRepository::class)
 */
class Circuito
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $tramo;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private $precio_circuito;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $foto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTramo(): ?int
    {
        return $this->tramo;
    }

    public function setTramo(int $tramo): self
    {
        $this->tramo = $tramo;

        return $this;
    }

    public function getPrecioCircuito(): ?float
    {
        return $this->precio_circuito;
    }

    public function setPrecioCircuito(float $precio_circuito): self
    {
        $this->precio_circuito = $precio_circuito;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }
}
