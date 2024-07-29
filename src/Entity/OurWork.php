<?php

namespace App\Entity;

use App\Repository\OurWorkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: OurWorkRepository::class)]
#[Vich\Uploadable]
class OurWork
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $workImage = null;

    #[Vich\UploadableField(mapping: 'our_work', fileNameProperty: 'workImage')]
    private ?File $vichWorkImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: WorkCategory::class, inversedBy: 'ourWork')]
    private Collection $workCategory;

    public function __construct()
    {
        $this->workCategory = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return OurWork
     */
    public function setTitle(?string $title): OurWork
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return OurWork
     */
    public function setSlug(?string $slug): OurWork
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return OurWork
     */
    public function setDescription(?string $description): OurWork
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWorkImage(): ?string
    {
        return $this->workImage;
    }

    /**
     * @param string|null $workImage
     * @return OurWork
     */
    public function setWorkImage(?string $workImage): OurWork
    {
        $this->workImage = $workImage;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getVichWorkImageFile(): ?File
    {
        return $this->vichWorkImageFile;
    }

    /**
     * @param File|null $vichWorkImageFile
     * @return OurWork
     */
    public function setVichWorkImageFile(?File $vichWorkImageFile = null): OurWork
    {
        $this->vichWorkImageFile = $vichWorkImageFile;
        if (null !== $vichWorkImageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt = null): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getWorkCategory(): Collection
    {
        return $this->workCategory;
    }

    public function addWorkCategory(WorkCategory $workCategory):static
    {
        if (!$this->workCategory->contains($workCategory)){
            $this->workCategory->add($workCategory);
        }
        return $this;
    }

    public function removeWorkCategory(WorkCategory $workCategory): static
    {
        $this->workCategory->removeElement($workCategory);

        return $this;
    }

    public function computeSlug(SluggerInterface $slugger): void
    {
        $this->slug = (string) $slugger->slug($this->title)->lower();
    }

}