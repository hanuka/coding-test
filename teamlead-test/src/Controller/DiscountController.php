<?php

namespace App\Controller;

use App\Service\DiscountCalculator;
use App\Service\FactoryDTOCreation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DiscountController extends AbstractController
{
    private DiscountCalculator $discountCalculator;
    private FactoryDTOCreation $factoryDTOCreation;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        DiscountCalculator $discountCalculator,
        FactoryDTOCreation $factoryDTOCreation,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->discountCalculator = $discountCalculator;
        $this->factoryDTOCreation = $factoryDTOCreation;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/api/discounts", name="api_discounts", methods={"POST"})
     */
    public function calculateDiscount(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $orderDTO = $this->factoryDTOCreation->createOrderDTO($data);

        $this->discountCalculator->calculateDiscount($orderDTO);

        return new JsonResponse([
            'original_total' => $orderDTO->getTotal(),
            'discount_amount' => round($orderDTO->getTotalDiscount(), 2),
            'reason' => $orderDTO->getDiscountReason(),
        ]);
    }
}