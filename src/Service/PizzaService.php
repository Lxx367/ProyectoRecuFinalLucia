<?php

namespace App\Service;

use App\Entity\Pizza;
use App\Models\PizzaDTO;
use App\Models\IngredientDTO;

class PizzaService
{
    public function toPizzaDTO(Pizza $pizza): PizzaDTO
    {
        $dto = new PizzaDTO();
        $dto->id = $pizza->getId();
        $dto->title = $pizza->getTitle();
        $dto->image = $pizza->getImage();
        $dto->price = $pizza->getPrice();
        $dto->okCeliacs = $pizza->isOkCeliacs();

        foreach ($pizza->getIngredients() as $ingredient) {
            $ingredientDTO = new IngredientDTO();
            $ingredientDTO->name = $ingredient->getName();
            $dto->ingredients[] = $ingredientDTO;
        }

        return $dto;
    }
}
