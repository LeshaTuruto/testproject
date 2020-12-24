<?php

namespace App\Repository;

use App\Entity\Tblproductdata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tblproductdata|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tblproductdata|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tblproductdata[]    findAll()
 * @method Tblproductdata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TblproductdataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tblproductdata::class);
    }

    public function findOneByCode($value): ?Tblproductdata
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.strproductcode = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
