<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BagRepository::class)]
#[ApiResource]
class Bag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'bag', targetEntity: Engagement::class, orphanRemoval: true)]
    private Collection $engagements;

    #[ORM\OneToMany(mappedBy: 'bag', targetEntity: Item::class, cascade: ['persist','remove'], orphanRemoval: true)]
    private Collection $items;

    public function __construct()
    {
        $this->engagements = new ArrayCollection();
        $this->items = new ArrayCollection();
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

    public function addEngagement(Engagement $engagement): static
    {
        if (!$this->engagements->contains($engagement)) {
            $this->engagements->add($engagement);
            $engagement->setBag($this);
        }

        return $this;
    }

    public function removeEngagement(Engagement $engagement): static
    {
        if ($this->engagements->removeElement($engagement)) {
            // set the owning side to null (unless already changed)
            if ($engagement->getBag() === $this) {
                $engagement->setBag(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setBag($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getBag() === $this) {
                $item->setBag(null);
            }
        }

        return $this;
    }
}
