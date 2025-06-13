<?php

namespace App\Models;

use Symfony\Component\Serializer\Annotation\SerializedName;
use App\Models\PizzaOrderDTO;
use App\Models\PaymentDTO;

class OrderRequestDTO
{
    #[SerializedName("delivery_time")]
    public string $deliveryTime;

    #[SerializedName("delivery_address")]
    public string $deliveryAddress;

    public PaymentDTO $payment;

    /** @var PizzaOrderDTO[] */
    #[SerializedName("pizzas_order")]
    public array $pizzas;
}
