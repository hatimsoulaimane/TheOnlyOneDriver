<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransfertRepository;
use App\Service\VtcAppInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=TransfertRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * @ApiResource(
 *     normalizationContext={"groups" = {"presta"}}
 * )
 */
class Transfert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"presta"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"presta"})
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $destination;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_passager;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_bagage;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"presta"})
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=LigneDeCmd::class, mappedBy="transfert")
     */
    private $ligneDeCmds;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="transfert")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $dispo;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="prestations", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"presta"})
     */
    private $imageName;

    public function __construct()
    {
        $this->ligneDeCmds = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getNbPassager(): ?int
    {
        return $this->nb_passager;
    }

    public function setNbPassager(?int $nb_passager): self
    {
        $this->nb_passager = $nb_passager;

        return $this;
    }

    public function getNbBagage(): ?int
    {
        return $this->nb_bagage;
    }

    public function setNbBagage(?int $nb_bagage): self
    {
        $this->nb_bagage = $nb_bagage;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
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

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function beforePersiste(){
        $this->titre = VtcAppInterface::capitalize($this->titre);
        $this->createdAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function beforeUpdate(){
        $this->titre = VtcAppInterface::capitalize($this->titre);
        $this->updatedAt = new DateTime();
    }

    public function __toString()
    {
        return $this->titre;
    }

    /**
     * @return Collection|LigneDeCmd[]
     */
    public function getLigneDeCmds(): Collection
    {
        return $this->ligneDeCmds;
    }

    public function addLigneDeCmd(LigneDeCmd $ligneDeCmd): self
    {
        if (!$this->ligneDeCmds->contains($ligneDeCmd)) {
            $this->ligneDeCmds[] = $ligneDeCmd;
            $ligneDeCmd->setTransfert($this);
        }

        return $this;
    }

    public function removeLigneDeCmd(LigneDeCmd $ligneDeCmd): self
    {
        if ($this->ligneDeCmds->contains($ligneDeCmd)) {
            $this->ligneDeCmds->removeElement($ligneDeCmd);
            // set the owning side to null (unless already changed)
            if ($ligneDeCmd->getTransfert() === $this) {
                $ligneDeCmd->setTransfert(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setTransfert($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getTransfert() === $this) {
                $commentaire->setTransfert(null);
            }
        }

        return $this;
    }

    public function getDispo(): ?bool
    {
        return $this->dispo;
    }

    public function setDispo(?bool $dispo): self
    {
        $this->dispo = $dispo;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

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
        if ( null !== $imageFile) {
            // Il est nécessaire qu'au moins un champ change si vous utilisez doctrine
            // sinon les écouteurs d'événements ne seront pas appelés et le fichier est perdu
            $this -> updatedAt = new DateTime();
        }
    }

}
