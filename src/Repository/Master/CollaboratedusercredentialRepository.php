<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedusercredential;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedusercredential|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedusercredential|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedusercredential[]    findAll()
 * @method Collaboratedusercredential[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedusercredentialRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedusercredential::class);
    // }

    // /**
    //  * @return Collaboratedusercredential[] Returns an array of Collaboratedusercredential objects
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
    public function findOneBySomeField($value): ?Collaboratedusercredential
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
