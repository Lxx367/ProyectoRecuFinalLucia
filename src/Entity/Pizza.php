<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PizzaRepository::class)]
class Pizza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?bool $okCeliacs = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'idPizza')]
    private Collection $ingredients;

    /**
     * @var Collection<int, PizzaOrder>
     */
    #[ORM\OneToMany(targetEntity: PizzaOrder::class, mappedBy: 'idPizza')]
    private Collection $pizzaOrders;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->pizzaOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isOkCeliacs(): ?bool
    {
        return $this->okCeliacs;
    }

    public function setOkCeliacs(bool $okCeliacs): static
    {
        $this->okCeliacs = $okCeliacs;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setIdPizza($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getIdPizza() === $this) {
                $ingredient->setIdPizza(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PizzaOrder>
     */
    public function getPizzaOrders(): Collection
    {
        return $this->pizzaOrders;
    }

    public function addPizzaOrder(PizzaOrder $pizzaOrder): static
    {
        if (!$this->pizzaOrders->contains($pizzaOrder)) {
            $this->pizzaOrders->add($pizzaOrder);
            $pizzaOrder->setIdPizza($this);
        }

        return $this;
    }

    public function removePizzaOrder(PizzaOrder $pizzaOrder): static
    {
        if ($this->pizzaOrders->removeElement($pizzaOrder)) {
            // set the owning side to null (unless already changed)
            if ($pizzaOrder->getIdPizza() === $this) {
                $pizzaOrder->setIdPizza(null);
            }
        }

        return $this;
    }
}
