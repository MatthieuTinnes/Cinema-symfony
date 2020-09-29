<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use App\Entity\Person;
use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=person::class, inversedBy="movies")
     */
    private $realisator;

    /**
     * @ORM\ManyToOne(targetEntity=category::class, inversedBy="movies")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=person::class)
     */
    private $casting;

    public function __construct()
    {
        $this->casting = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRealisator(): ?person
    {
        return $this->realisator;
    }

    public function setRealisator(?person $realisator): self
    {
        $this->realisator = $realisator;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|person[]
     */
    public function getCasting(): Collection
    {
        return $this->casting;
    }

    public function addCasting(person $casting): self
    {
        if (!$this->casting->contains($casting)) {
            $this->casting[] = $casting;
        }

        return $this;
    }

    public function removeCasting(person $casting): self
    {
        if ($this->casting->contains($casting)) {
            $this->casting->removeElement($casting);
        }

        return $this;
    }
}
