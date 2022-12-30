<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Program::class)]
    private Collection $Programs;

    public function __construct()
    {
        $this->Programs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->Programs;
    }

    public function addProgram(Program $Program): self
    {
        if (!$this->Programs->contains($Program)) {
            $this->Programs->add($Program);
            $Program->setCategory($this);
        }

        return $this;
    }

    public function removeProgram(Program $Program): self
    {
        if ($this->Programs->removeElement($Program)) {
            // set the owning side to null (unless already changed)
            if ($Program->getCategory() === $this) {
                $Program->setCategory(null);
            }
        }

        return $this;
    }
}
