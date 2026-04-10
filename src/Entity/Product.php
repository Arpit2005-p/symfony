<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\UniqueConstraint(name: 'referance_unique', fields: ['referance'])]
#[UniqueEntity(fields: ['referance'], message: 'all ready exist referance')]
#[ORM\HasLifecycleCallbacks]
class Product
{                               
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $referance = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToOne(mappedBy: 'product', cascade: ['persist', 'remove'])]
    private ?Ring $ring = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 0)]
    private ?string $price = null;
    
    #[ORM\Column(nullable: true)]
    private ?\DateTime $created = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updated = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $status = true;

    #[ORM\OneToOne(mappedBy: 'product', cascade: ['persist', 'remove'])]
    private ?Bracelete $bracelete = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'product')]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getReferance(): ?string
    {
        return $this->referance;
    }

    public function setReferance(string $referance): static
    {
        $this->referance = $referance;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getRing(): ?Ring
    {
        return $this->ring;
    }

    public function setRing(Ring $ring): static
    {
        // set the owning side of the relation if necessary
        if ($ring->getProduct() !== $this) {
            $ring->setProduct($this);
        }

        $this->ring = $ring;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    public function setUpdated(\DateTime $updated): static
    {
        $this->updated = $updated;

        return $this;
    }
    
     #[ORM\PrePersist]
    public function setCreatedValue(): void
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function setUpdatedValue(): void
    {
        $this->updated = new \DateTime();
    }


    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBracelete(): ?Bracelete
    {
        return $this->bracelete;
    }

    public function setBracelete(Bracelete $bracelete): static
    {
        // set the owning side of the relation if necessary
        if ($bracelete->getProduct() !== $this) {
            $bracelete->setProduct($this);
        }

        $this->bracelete = $bracelete;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }
}
