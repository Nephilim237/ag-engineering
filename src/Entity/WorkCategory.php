<?php

namespace App\Entity;

use App\Repository\WorkCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
Use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: WorkCategoryRepository::class)]
class WorkCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, OurWork>
     */
    #[ORM\OneToMany(targetEntity: OurWork::class, mappedBy: 'workCategory')]
    private Collection $ourWorks;

    public function __construct()
    {
        $this->ourWorks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title = null): self
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getOurWorks(): Collection
    {
        return $this->ourWorks;
    }

    public function addOurWork(OurWork $ourWork): self
    {
        if (!$this->ourWorks->contains($ourWork)){
            $this->ourWorks->add($ourWork);
            $ourWork->addWorkCategory($this);
        }

        return $this;
    }

    public function removeOurWork(OurWork $ourWork): static
    {
        if ($this->ourWorks->removeElement($ourWork))
        {
            $ourWork->removeWorkCategory($this);
        }

        return $this;
    }

    public function computeSlug(SluggerInterface $slugger): void
    {
        $this->slug = (string) $slugger->slug($this->title)->lower();
    }
}