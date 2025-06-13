<?php

namespace App\Models;

use Symfony\Component\Serializer\Annotation\SerializedName;

class PizzaDTO
{
    public int $id;
    public string $title;
    public string $image;
    public float $price;

    #[SerializedName("ok_celiacs")]
    public bool $okCeliacs;

    /** @var IngredientDTO[] */
    public array $ingredients = [];
}
