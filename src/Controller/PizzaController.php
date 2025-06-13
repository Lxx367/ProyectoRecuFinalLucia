<?php

namespace App\Controller;

use App\Repository\PizzaRepository;
use App\Service\PizzaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/pizzas')]
class PizzaController extends AbstractController
{
    public function __construct(
        private PizzaRepository $pizzaRepository,
        private PizzaService $pizzaService
    ) {}

    #[Route('', name: 'get_pizzas', methods: ['GET'])]
    public function getPizzas(Request $request): JsonResponse
    {
        $name = $request->query->get('name');
        $ingredients = $request->query->get('ingredients');

        if ($name) {
            $pizzas = $this->pizzaRepository->findByNameContains($name);
        } elseif ($ingredients) {
            $pizzas = $this->pizzaRepository->findByIngredients($ingredients);
        } else {
            $pizzas = $this->pizzaRepository->findAll();
        }

        $result = [];
        foreach ($pizzas as $pizza) {
            $result[] = $this->pizzaService->toPizzaDTO($pizza);
        }

        return $this->json($result);
    }
}
