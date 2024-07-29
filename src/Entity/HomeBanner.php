<?php

namespace App\Entity;

use App\Repository\HomeBannerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: HomeBannerRepository::class)]
#[Vich\Uploadable]
class HomeBanner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $caption = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $secondCaption = null;

    #[ORM\Column(length: 255)]
    private ?string $bannerImage = null;

    #[Vich\UploadableField(mapping: 'homeBanners', fileNameProperty: 'bannerImage')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): static
    {
        $this->caption = $caption;

        return $this;
    }

    public function getSecondCaption(): ?string
    {
        return $this->secondCaption;
    }

    public function setSecondCaption(?string $caption = null): self
    {
        $this->secondCaption = $caption;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBannerImage(): ?string
    {
        return $this->bannerImage;
    }

    /**
     * @param string|null $bannerImage
     * @return HomeBanner
     */
    public function setBannerImage(?string $bannerImage): HomeBanner
    {
        $this->bannerImage = $bannerImage;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return HomeBanner
     */
    public function setImageFile(?File $imageFile = null): HomeBanner
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile){
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
}
