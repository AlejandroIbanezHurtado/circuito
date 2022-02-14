<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CocheRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CocheRepository::class)
 */
class Coche implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Modelo::class, inversedBy="coches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modelo;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\OneToMany(targetEntity=DetalleReserva::class, mappedBy="coche")
     */
    private $detalleReservas;

    public function __construct()
    {
        $this->detalleReservas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelo(): ?Modelo
    {
        return $this->modelo;
    }

    public function setModelo(?Modelo $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
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
            $detalleReserva->setCoche($this);
        }

        return $this;
    }

    public function removeDetalleReserva(DetalleReserva $detalleReserva): self
    {
        if ($this->detalleReservas->removeElement($detalleReserva)) {
            // set the owning side to null (unless already changed)
            if ($detalleReserva->getCoche() === $this) {
                $detalleReserva->setCoche(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return strval($this->modelo);
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
