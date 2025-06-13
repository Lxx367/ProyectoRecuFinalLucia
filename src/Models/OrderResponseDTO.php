<?php

namespace App\Models;

use App\Models\PizzaOrderResponseDTO;

class OrderResponseDTO
{
    public int $id;

    /** @var PizzaOrderResponseDTO[] */
    public array $pizzas;
}
