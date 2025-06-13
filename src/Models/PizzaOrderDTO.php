<?php

namespace App\Models;
use Symfony\Component\Serializer\Annotation\SerializedName;

class PizzaOrderDTO
{
    #[SerializedName("pizza_id")]
    public int $idPizza;
    public int $quantity;
}
