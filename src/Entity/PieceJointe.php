<?php

namespace App\Entity;

use App\Repository\PieceJointeRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PieceJointeRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class PieceJointe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="pieces_jointes", fileNameProperty="imageName")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Prestation::class, inversedBy="pieceJointes")
     */
    private $prestation;

//    /**
//     * @Gedmo\Slug(fields={"imageName"})
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $slug;
//
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getImageName(): ?string
    {
        return $this->imageName;
    }


    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }


    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        if(null !== $imageFile) {
            $this->updatedAt = new DateTime();
        }
    }


    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }


    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


//    public function getSlug(): ?string
//    {
//        return $this->slug;
//    }
//
//    public function setSlug(?string $slug): self
//    {
//        $this->slug = $slug;
//
//        return $this;
//    }

    /**
     * @ORM\PrePersist
     */
    public function beforePersist()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function beforeUpdate()
    {
        $this->updatedAt = new DateTime();
    }

    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): self
    {
        $this->prestation = $prestation;

        return $this;
    }
}
