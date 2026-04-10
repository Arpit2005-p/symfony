<?php

namespace App\Entity;

use App\Repository\BraceleteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BraceleteRepository::class)]
class Bracelete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $length = null;

    #[ORM\Column(length: 255)]
    private ?string $braceletetype = null;

    #[ORM\Column]
    private ?bool $adjustable = null;

    #[ORM\OneToOne(inversedBy: 'bracelete', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id',nullable: false)]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(string $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getBraceletetype(): ?string
    {
        return $this->braceletetype;
    }

    public function setBraceletetype(string $braceletetype): static
    {
        $this->braceletetype = $braceletetype;

        return $this;
    }

    public function isAdjustable(): ?bool
    {
        return $this->adjustable;
    }

    public function setAdjustable(bool $adjustable): static
    {
        $this->adjustable = $adjustable;

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
}
