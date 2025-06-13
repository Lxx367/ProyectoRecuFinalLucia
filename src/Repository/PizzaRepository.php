<?php

namespace App\Repository;

use App\Entity\Pizza;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class PizzaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pizza::class);
    }

    public function findByNameContains(string $name): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    public function findByIngredients(string $ingredients): array
    {
        $ingredientList = array_map('trim', explode(',', $ingredients));

        $qb = $this->createQueryBuilder('p')
            ->join('p.ingredients', 'i');

        $orX = $qb->expr()->orX();
        foreach ($ingredientList as $ingredient) {
            $orX->add($qb->expr()->like('i.name', ':ingredient_' . $ingredient));
            $qb->setParameter('ingredient_' . $ingredient, '%' . $ingredient . '%');
        }

        $qb->where($orX);

        return $qb->getQuery()->getResult();
    }
}
