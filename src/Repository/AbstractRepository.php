<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 1)
    {
        if (!($limit > 0 && $offset >= 0)) {
            throw new \LogicException('$limit & $offset must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));

        $currentPage = ceil($offset  / $limit);

        $pager->setCurrentPage($currentPage>$pager->getNbPages()?$pager->getNbPages():$currentPage);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }
}
