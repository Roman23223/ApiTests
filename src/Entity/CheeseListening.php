<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CheeseListeningRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CheeseListeningRepository::class)]
#[ApiResource(
    shortName: 'cheses',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['cheses.read']],
    denormalizationContext: ['groups' => ['cheses.write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'title' => 'ipartial', 'description' => 'ipartial', 'price' => 'exact'])]
#[UniqueEntity("title", message: "Рессурс с таким заголовком уже существует")]
class CheeseListening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['cheses.read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cheses.read', 'cheses.write'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        minMessage: "Минимальное кол-во символов 5",
        max: 10,
        maxMessage: "Максимальное количество 10",
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cheses.read', 'cheses.write'])]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['cheses.read', 'cheses.write'])]
    #[Assert\NotBlank]
    private ?int $price = null;

    #[ORM\Column]
    #[Groups(['cheses.read', 'cheses.write'])]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['cheses.read', 'cheses.write'])]
    #[Assert\NotBlank]
    private ?bool $isPublished = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
