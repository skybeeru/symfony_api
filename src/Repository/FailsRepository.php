<?php

namespace App\Repository;

use App\Entity\Fails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fails|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fails|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fails[]    findAll()
 * @method Fails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fails::class);
    }

    // /**
    //  * @return Fails[] Returns an array of Fails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fails
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
