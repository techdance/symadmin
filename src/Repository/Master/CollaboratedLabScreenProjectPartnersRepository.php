<?php

namespace App\Repository\Master;

use App\Entity\Master\CollaboratedLabScreenProjectPartners;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollaboratedLabScreenProjectPartners|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollaboratedLabScreenProjectPartners|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollaboratedLabScreenProjectPartners[]    findAll()
 * @method CollaboratedLabScreenProjectPartners[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedLabScreenProjectPartnersRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, CollaboratedLabScreenProjectPartners::class);
    // }

    // /**
    //  * @return CollaboratedLabScreenProjectPartners[] Returns an array of CollaboratedLabScreenProjectPartners objects
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
    public function findOneBySomeField($value): ?CollaboratedLabScreenProjectPartners
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
