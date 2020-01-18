<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 */
class Chat
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
    private $idUsuario1;

    /**
     * @ORM\Column(type="integer")
     */
    private $idUsuario2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $asunto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUsuario1(): ?int
    {
        return $this->idUsuario1;
    }

    public function setIdUsuario1(int $idUsuario1): self
    {
        $this->idUsuario1 = $idUsuario1;

        return $this;
    }

    public function getIdUsuario2(): ?int
    {
        return $this->idUsuario2;
    }

    public function setIdUsuario2(int $idUsuario2): self
    {
        $this->idUsuario2 = $idUsuario2;

        return $this;
    }

    public function getAsunto(): ?string
    {
        return $this->asunto;
    }

    public function setAsunto(string $asunto): self
    {
        $this->asunto = $asunto;

        return $this;
    }
}
