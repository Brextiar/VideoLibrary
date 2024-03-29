<?php

namespace App\Entity;

use App\Repository\CounterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CounterRepository::class)]
class Counter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $count = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }
    
    /**
     * @param int $count
     *
     * @return $this
     */
    public function setCount(int $count): static
    {
        $this->count = $count;

        return $this;
    }
}
