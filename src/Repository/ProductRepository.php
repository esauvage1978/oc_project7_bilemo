<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function search($wordsearch, $order = 'asc', $limit = 20,$offset=1)
    {
        $productAlias='p';

        $qb = $this
            ->createQueryBuilder($productAlias)
            ->select($productAlias)
            ->orderBy($productAlias .'.name', $order)
        ;

        if ($wordsearch) {
            $qb
                ->where($productAlias. '.name LIKE ?1')
                ->setParameter(1, '%'.$wordsearch.'%')
            ;
        }

        return $this->paginate($qb, $limit,$offset);
    }
}
