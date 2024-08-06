<?php

namespace App\Entity;

use App\Repository\ContinentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContinentRepository::class)]
class Continent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    /**
     * @var Collection<int, Cryptide>
     */
    #[ORM\OneToMany(targetEntity: Cryptide::class, mappedBy: 'idContinent')]
    private Collection $cryptides;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->cryptides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, Cryptide>
     */
    public function getCryptides(): Collection
    {
        return $this->cryptides;
    }

    public function addCryptide(Cryptide $cryptide): static
    {
        if (!$this->cryptides->contains($cryptide)) {
            $this->cryptides->add($cryptide);
            $cryptide->setIdContinent($this);
        }

        return $this;
    }

    public function removeCryptide(Cryptide $cryptide): static
    {
        if ($this->cryptides->removeElement($cryptide)) {
            // set the owning side to null (unless already changed)
            if ($cryptide->getIdContinent() === $this) {
                $cryptide->setIdContinent(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
