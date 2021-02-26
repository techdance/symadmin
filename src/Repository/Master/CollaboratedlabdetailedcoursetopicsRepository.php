<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedlabdetailedcoursetopics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedlabdetailedcoursetopics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedlabdetailedcoursetopics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedlabdetailedcoursetopics[]    findAll()
 * @method Collaboratedlabdetailedcoursetopics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedlabdetailedcoursetopicsRepository  extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedlabdetailedcoursetopics::class);
    // }

    // /**
    //  * @return Collaboratedlabdetailedcoursetopics[] Returns an array of Collaboratedlabdetailedcoursetopics objects
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
    public function findOneBySomeField($value): ?Collaboratedlabdetailedcoursetopics
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
