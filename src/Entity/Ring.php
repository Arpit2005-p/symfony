<?php

namespace App\Entity;

use App\Repository\RingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RingRepository::class)]
class Ring
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\OneToOne(inversedBy: 'ring', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id',nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    private ?string $stonetype = null;

    #[ORM\Column(length: 255)]
    private ?string $style = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $weight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getProduct(): ?product
    {
        return $this->product;
    }

    public function setProduct(product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getStonetype(): ?string
    {
        return $this->stonetype;
    }

    public function setStonetype(string $stonetype): static
    {
        $this->stonetype = $stonetype;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): static
    {
        $this->weight = $weight;

        return $this;
    }
}
