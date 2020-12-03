<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=LigneDeCmd::class, mappedBy="commande")
     */
    private $ligneDeCmd;

    public function __construct()
    {
        $this->ligneDeCmd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|LigneDeCmd[]
     */
    public function getLigneDeCmd(): Collection
    {
        return $this->ligneDeCmd;
    }

    public function addLigneDeCmd(LigneDeCmd $ligneDeCmd): self
    {
        if (!$this->ligneDeCmd->contains($ligneDeCmd)) {
            $this->ligneDeCmd[] = $ligneDeCmd;
            $ligneDeCmd->setCommande($this);
        }

        return $this;
    }

    public function removeLigneDeCmd(LigneDeCmd $ligneDeCmd): self
    {
        if ($this->ligneDeCmd->contains($ligneDeCmd)) {
            $this->ligneDeCmd->removeElement($ligneDeCmd);
            // set the owning side to null (unless already changed)
            if ($ligneDeCmd->getCommande() === $this) {
                $ligneDeCmd->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function beforePersiste(){
        $this->createdAt = new DateTime();
//        $this->dateCommande = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function beforeUpdate(){

        $this->updatedAt = new DateTime();

    }
}
