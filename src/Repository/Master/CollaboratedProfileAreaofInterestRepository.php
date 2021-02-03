<?php

namespace App\Repository\Master;

use App\Entity\Master\CollaboratedProfileAreaofInterest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollaboratedProfileAreaofInterest|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollaboratedProfileAreaofInterest|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollaboratedProfileAreaofInterest[]    findAll()
 * @method CollaboratedProfileAreaofInterest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedProfileAreaofInterestRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, CollaboratedProfileAreaofInterest::class);
    // }

    // /**
    //  * @return CollaboratedProfileAreaofInterest[] Returns an array of CollaboratedProfileAreaofInterest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CollaboratedProfileAreaofInterest
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
