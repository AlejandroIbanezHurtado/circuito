<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ModeloRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ModeloRepository::class)
 */
class Modelo implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Marca::class, inversedBy="modelos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marca;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=Coche::class, mappedBy="modelo")
     */
    private $coches;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagen;

    public function __construct()
    {
        $this->coches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function setMarca(?Marca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection|Coche[]
     */
    public function getCoches(): Collection
    {
        return $this->coches;
    }

    public function addCoch(Coche $coch): self
    {
        if (!$this->coches->contains($coch)) {
            $this->coches[] = $coch;
            $coch->setModelo($this);
        }

        return $this;
    }

    public function removeCoch(Coche $coch): self
    {
        if ($this->coches->removeElement($coch)) {
            // set the owning side to null (unless already changed)
            if ($coch->getModelo() === $this) {
                $coch->setModelo(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
