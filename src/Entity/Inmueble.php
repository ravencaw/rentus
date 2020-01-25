<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InmuebleRepository")
 */
class Inmueble
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipoInmueble;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="float")
     */
    private $superficie;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zona;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ciudad;

    /**
     * @ORM\Column(type="integer")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitud;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitud;

    /**
     * @ORM\Column(type="integer")
     */
    private $habitaciones;

    /**
     * @ORM\Column(type="integer")
     */
    private $bathroom;

    /**
     * @ORM\Column(type="text")
     */
    private $comentarios;

    /**
     * @ORM\Column(type="text")
     */
    private $extras;

    /**
     * @ORM\Column(type="integer")
     */
    private $idCreador;

    /**
     * @ORM\Column(type="smallint")
     */
    private $disponible;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoInmueble(): ?string
    {
        return $this->tipoInmueble;
    }

    public function setTipoInmueble(string $tipoInmueble): self
    {
        $this->tipoInmueble = $tipoInmueble;

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

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getZona(): ?string
    {
        return $this->zona;
    }

    public function setZona(string $zona): self
    {
        $this->zona = $zona;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(string $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }


    public function getLatitud(): ?string
    {
        return $this->latitud;
    }
    
    public function setLatitud(string $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getHabitaciones(): ?int
    {
        return $this->habitaciones;
    }

    public function setHabitaciones(int $habitaciones): self
    {
        $this->habitaciones = $habitaciones;

        return $this;
    }

    public function getBathroom(): ?int
    {
        return $this->bathroom;
    }

    public function setBathroom(int $bathroom): self
    {
        $this->bathroom = $bathroom;

        return $this;
    }

    public function getComentarios(): ?string
    {
        return $this->comentarios;
    }

    public function setComentarios(string $comentarios): self
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    public function getExtras(): ?string
    {
        return $this->extras;
    }

    public function setExtras(string $extras): self
    {
        $this->extras = $extras;

        return $this;
    }

    public function getIdCreador(): ?int
    {
        return $this->idCreador;
    }

    public function setIdCreador(int $idCreador): self
    {
        $this->idCreador = $idCreador;

        return $this;
    }

    public function getDisponible(): ?int
    {
        return $this->disponible;
    }

    public function setDisponible(int $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }
}
