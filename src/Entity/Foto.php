<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FotoRepository")
 */
class Foto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idInmueble;

    /**
     * @ORM\Column(type="text")
     */
    private $ruta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdInmueble(): ?int
    {
        return $this->idInmueble;
    }

    public function setIdInmueble(int $idInmueble): self
    {
        $this->idInmueble = $idInmueble;

        return $this;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(string $ruta): self
    {
        $this->ruta = $ruta;

        return $this;
    }
}
