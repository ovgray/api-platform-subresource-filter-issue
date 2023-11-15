<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ApiResource]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: Engagement::class, orphanRemoval: true)]
    private Collection $engagements;

    public function __construct()
    {
        $this->engagements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Engagement>
     */
    public function getEngagements(): Collection
    {
        return $this->engagements;
    }

    public function addEngagement(Engagement $engagement): void
    {
        if (!$this->engagements->contains($engagement)) {
            $this->engagements->add($engagement);
            $engagement->setPerson($this);
        }
    }

    public function removeEngagement(Engagement $engagement): void
    {
        if ($this->engagements->removeElement($engagement)) {
            // set the owning side to null (unless already changed)
            if ($engagement->getPerson() === $this) {
                $engagement->setPerson(null);
            }
        }
    }
}
