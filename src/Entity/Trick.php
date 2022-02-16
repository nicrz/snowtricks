<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TrickRepository;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Figure
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 * @UniqueEntity(fields={"name"}, message="Il existe déjà une figure avec cette appelation")
 */
class Trick
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
     * @var string
     *
     * @ORM\Column(name="main_image", type="string", length=100, nullable=false)
     */
    private $main_image;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=10000, nullable=false)
     */
    private $description;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMain_image(): ?string
    {
        return $this->main_image;
    }

    public function setMain_image(string $main_image): self
    {
        $this->main_image = $main_image;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


}