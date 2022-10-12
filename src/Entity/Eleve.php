<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use App\TraitCRUD\TimeStampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
#[ORM\HasLifecycleCallbacks]
// #[Vich\Uploadable]
class Eleve
{
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $surname = null;

    #[ORM\Column]
    private ?\DateTime $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

         // NOTE: This is not a mapped field of entity metadata, just a simple property.
    // #[Vich\UploadableField(mapping: 'eleves', fileNameProperty: 'imageName', size: 'imageSize')]
    // private ?File $imageFile = null;

    // #[ORM\Column(type: 'string')]
    // private ?string $imageName = null;

    // #[ORM\Column(type: 'integer')]
    // private ?int $imageSize = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $desciption = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateInsriptionAt = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guardian $guardian = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gendre $gendre = null;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDesciption(): ?string
    {
        return $this->desciption;
    }

    public function setDesciption(?string $desciption): self
    {
        $this->desciption = $desciption;

        return $this;
    }

    public function getDateInsriptionAt(): ?\DateTime
    {
        return $this->dateInsriptionAt;
    }

    public function setDateInsriptionAt(?\DateTime $dateInsriptionAt): self
    {
        $this->dateInsriptionAt = $dateInsriptionAt;

        return $this;
    }

    public function getGuardian(): ?Guardian
    {
        return $this->guardian;
    }

    public function setGuardian(?Guardian $guardian): self
    {
        $this->guardian = $guardian;

        return $this;
    }

    public function getGendre(): ?Gendre
    {
        return $this->gendre;
    }

    public function setGendre(?Gendre $gendre): self
    {
        $this->gendre = $gendre;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    // public function setImageFile(?File $imageFile = null): void
    // {
    //     $this->imageFile = $imageFile;

    //     if (null !== $imageFile) {
    //         // It is required that at least one field changes if you are using doctrine
    //         // otherwise the event listeners won't be called and the file is lost
    //         $this->updatedAt = new \DateTimeImmutable();
    //     }
    // }

    // public function getImageFile(): ?File
    // {
    //     return $this->imageFile;
    // }

    // public function setImageName(?string $imageName): void
    // {
    //     $this->imageName = $imageName;
    // }

    // public function getImageName(): ?string
    // {
    //     return $this->imageName;
    // }

    // public function setImageSize(?int $imageSize): void
    // {
    //     $this->imageSize = $imageSize;
    // }

    // public function getImageSize(): ?int
    // {
    //     return $this->imageSize;
    // }

}
