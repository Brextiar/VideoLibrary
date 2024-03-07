<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    #[Assert\NotNull]
    #[Assert\Length(min: 10, max: 250)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotNull]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creatingDate = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $poster = null;

    #[ORM\ManyToOne(inversedBy: 'films')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Category $categories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatingDate(): ?\DateTimeInterface
    {
        return $this->creatingDate;
    }
    
    #[ORM\PrePersist]
    public function setCreatingDate(): static
    {
        $this->creatingDate = new \DateTime();

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): static
    {
        $this->categories = $categories;

        return $this;
    }
}
