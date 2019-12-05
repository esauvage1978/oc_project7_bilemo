<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function search($client_id, $wordsearch, $order = 'asc', $limit = 20,$offset=1)
    {
        $qb = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->Where('u.client = :id')
            ->setParameter('id', $client_id)
            ->orderBy('u.username', $order)
        ;

        if ($wordsearch) {
            $qb
                ->andWhere('u.username LIKE ?1')
                ->setParameter(1, '%'.$wordsearch.'%')
            ;
        }

        return $this->paginate($qb, $limit,$offset);
    }
}
