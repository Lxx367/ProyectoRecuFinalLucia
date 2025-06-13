<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $deliveryTime = null;

    #[ORM\Column(length: 255)]
    private ?string $deliveryAddress = null;

    /**
     * @var Collection<int, PizzaOrder>
     */
    #[ORM\OneToMany(targetEntity: PizzaOrder::class, mappedBy: 'idOrder')]
    
    private Collection $pizzaOrders;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Payment $payment = null;

    public function __construct()
    {
        $this->pizzaOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryTime(): ?string
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime(string $deliveryTime): static
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(string $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;

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
            $pizzaOrder->setIdOrder($this);
        }

        return $this;
    }

    public function removePizzaOrder(PizzaOrder $pizzaOrder): static
    {
        if ($this->pizzaOrders->removeElement($pizzaOrder)) {
            // set the owning side to null (unless already changed)
            if ($pizzaOrder->getIdOrder() === $this) {
                $pizzaOrder->setIdOrder(null);
            }
        }

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): static
    {
        $this->payment = $payment;

        return $this;
    }
}
