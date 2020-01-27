<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CitaRepository")
 */
class Cita
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_hora;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_usuario1;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_usuario2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ciudad;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitud;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitud;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHora(): ?\DateTimeInterface
    {
        return $this->fecha_hora;
    }

    public function setFechaHora(\DateTimeInterface $fecha_hora): self
    {
        $this->fecha_hora = $fecha_hora;

        return $this;
    }

    public function getIdUsuario1(): ?int
    {
        return $this->id_usuario1;
    }

    public function setIdUsuario1(int $id_usuario1): self
    {
        $this->id_usuario1 = $id_usuario1;

        return $this;
    }

    public function getIdUsuario2(): ?int
    {
        return $this->id_usuario2;
    }

    public function setIdUsuario2(int $id_usuario2): self
    {
        $this->id_usuario2 = $id_usuario2;

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

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

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
}
