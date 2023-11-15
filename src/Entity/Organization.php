<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
#[ApiResource]
class Organization
{
    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Engagement::class, cascade: ['persist','remove'],
        orphanRemoval: true)]
    private Collection $engagements;

    #[ApiProperty(identifier: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(length: 10, unique: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->engagements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function addEngagement(Engagement $engagement): void
    {
        if (!$this->engagements->contains($engagement)) {
            $this->engagements->add($engagement);
            $engagement->setOrganization($this);
        }
    }

    /**
     * @return Collection<int, Engagement>
     */
    public function getEngagements(): Collection
    {
        return $this->engagements;
    }

    public function removeEngagement(Engagement $engagement): void
    {
        if ($this->engagements->removeElement($engagement)) {
            // set the owning side to null (unless already changed)
            if ($engagement->getOrganization() === $this) {
                $engagement->setOrganization(null);
            }
        }
    }
}
