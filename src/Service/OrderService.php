<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\Pizza;
use App\Entity\PizzaOrder;
use App\Models\OrderRequestDTO;
use App\Models\OrderResponseDTO;
use App\Models\PizzaOrderResponseDTO;
use App\Models\ValidationErrorDTO;
use App\Repository\PizzaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderService
{
    public function __construct(
        private EntityManagerInterface $em,
        private PizzaRepository $pizzaRepository
    ) {}

    public function processOrder(OrderRequestDTO $dto): OrderResponseDTO
    {
        // Validaciones
        if (empty($dto->deliveryAddress)) {
            throw new BadRequestHttpException("The delivery address is mandatory");
        }

        if (empty($dto->deliveryTime)) {
            throw new BadRequestHttpException("The delivery time is mandatory");
        }

        if (empty($dto->payment)) {
            throw new BadRequestHttpException("The payment information is mandatory");
        }

        if (!in_array($dto->payment->paymentType, ['credit_card', 'bizum'])) {
            throw new BadRequestHttpException("Invalid payment type");
        }

        if ($dto->payment->paymentType === 'credit_card' &&
            !preg_match('/^\d{4}-\d{4}-\d{4}-\d{4}$/', $dto->payment->number)) {
            throw new BadRequestHttpException("Invalid credit card format");
        }

        if ($dto->payment->paymentType === 'bizum' &&
            !preg_match('/^\d{9}$/', $dto->payment->number)) {
            throw new BadRequestHttpException("Invalid bizum format");
        }

        // Creamos el Payment
        $payment = new Payment();
        $payment->setPaymentType($dto->payment->paymentType);
        $payment->setNumber($dto->payment->number);

        // Creamos el Order
        $order = new Order();
        $order->setDeliveryAddress($dto->deliveryAddress);
        $order->setDeliveryTime($dto->deliveryTime);
        $order->setPayment($payment);

        $this->em->persist($payment);
        $this->em->persist($order);

        $pizzaResponses = [];

        foreach ($dto->pizzas as $pizzaDTO) {
            $pizza = $this->pizzaRepository->find($pizzaDTO->idPizza);

            if (!$pizza) {
                throw new BadRequestHttpException("Pizza with ID {$pizzaDTO->idPizza} does not exist");
            }

            $pizzaOrder = new PizzaOrder();
            $pizzaOrder->setIdPizza($pizza);
            $pizzaOrder->setIdOrder($order);
            $pizzaOrder->setQuantity($pizzaDTO->quantity);

            $this->em->persist($pizzaOrder);

            $pizzaResponse = new PizzaOrderResponseDTO();
            $pizzaResponse->idPizza = $pizza->getId();
            $pizzaResponse->title = $pizza->getTitle();
            $pizzaResponse->price = $pizza->getPrice();
            $pizzaResponse->quantity = $pizzaDTO->quantity;

            $pizzaResponses[] = $pizzaResponse;
        }

        $this->em->flush();

        $response = new OrderResponseDTO();
        $response->id = $order->getId();
        $response->pizzas = $pizzaResponses;

        return $response;
    }
}
