<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaborateduserprofessionalbio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaborateduserprofessionalbio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaborateduserprofessionalbio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaborateduserprofessionalbio[]    findAll()
 * @method Collaborateduserprofessionalbio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaborateduserprofessionalbioRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaborateduserprofessionalbio::class);
    // }

    // /**
    //  * @return Collaborateduserprofessionalbio[] Returns an array of Collaborateduserprofessionalbio objects
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
    public function findOneBySomeField($value): ?Collaborateduserprofessionalbio
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
