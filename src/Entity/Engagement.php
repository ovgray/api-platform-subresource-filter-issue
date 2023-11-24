<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\ApiPlatform\EngagementBagItemQuantityFilter;
use App\Repository\EngagementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EngagementRepository::class)]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/organizations/{code}/engagements.{_format}',
    operations: [new GetCollection()],
    uriVariables: ['code' => new Link(fromProperty: 'engagements', fromClass: Organization::class)],
)]
#[ApiFilter(BooleanFilter::class, properties: ['active'])]
#[ApiFilter(filterClass: EngagementBagItemQuantityFilter::class)]
class Engagement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'engagements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    #[ORM\ManyToOne(inversedBy: 'engagements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organization $organization = null;

    #[ORM\ManyToOne(inversedBy: 'engagements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bag $bag = null;

    #[ORM\Column]
    private bool $active = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): static
    {
        $this->person = $person;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function getBag(): ?Bag
    {
        return $this->bag;
    }

    public function setBag(?Bag $bag): static
    {
        $this->bag = $bag;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
