<?php

namespace App\Repository;

use App\Entity\Ladder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ladder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ladder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ladder[]    findAll()
 * @method Ladder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LadderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ladder::class);
    }

    // /**
    //  * @return Ladder[] Returns an array of Ladder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ladder
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
