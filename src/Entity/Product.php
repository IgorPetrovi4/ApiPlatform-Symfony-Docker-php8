<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get','delete', 'patch'],
    denormalizationContext: ['groups' => ['product:write']],
    normalizationContext: ['groups' => ['product:read', 'category:read']]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Groups(['product:write'])]
    private ?Category $category = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min:3,max:50)]
    #[Groups(['product:write', 'product:read'])]
    private ?string $name = null;

    #[Groups(['category:read'])]
    private ?string $categoryName = null;

    #[ORM\Column]
    #[Assert\Range(min:0,max:200)]
    #[Groups(['product:write', 'product:read'])]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName = $this->category->getName();
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
