<?php

namespace App\Controller;

use App\Models\OrderRequestDTO;
use App\Models\ValidationErrorDTO;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/orders')]
class OrderController extends AbstractController
{
    public function __construct(
        private OrderService $orderService,
        private SerializerInterface $serializer
    ) {}

    #[Route('', name: 'create_order', methods: ['POST'])]
    public function createOrder(Request $request): JsonResponse
    {
        try {
            $orderRequest = $this->serializer->deserialize(
                $request->getContent(),
                OrderRequestDTO::class,
                'json'
            );

            $orderResponse = $this->orderService->processOrder($orderRequest);

            return $this->json($orderResponse);
        } catch (BadRequestHttpException $e) {
            $errorDTO = new ValidationErrorDTO(21, $e->getMessage());
            return $this->json($errorDTO, 400);
        } catch (\Exception $e) {
            $errorDTO = new ValidationErrorDTO(99, 'Internal server error');
            return $this->json($errorDTO, 500);
        }
    }
}
