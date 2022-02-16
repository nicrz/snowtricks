<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;

/**
 * Media
 *
 * @ORM\Table(name="media", indexes={@ORM\Index(name="idtrick", columns={"idtrick"})})
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10000, nullable=true)
     */
    private $code;

    /**
     * @var \Trick
     *
     * @ORM\ManyToOne(targetEntity="Trick")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtrick", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idtrick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->idtrick;
    }

    public function setTrick(?Trick $idtrick): self
    {
        $this->idtrick = $idtrick;

        return $this;
    }


}