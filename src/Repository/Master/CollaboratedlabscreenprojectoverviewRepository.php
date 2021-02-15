<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedlabscreenprojectoverview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedlabscreenprojectoverview|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedlabscreenprojectoverview|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedlabscreenprojectoverview[]    findAll()
 * @method Collaboratedlabscreenprojectoverview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedlabscreenprojectoverviewRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedlabscreenprojectoverview::class);
    // }

    // /**
    //  * @return Collaboratedlabscreenprojectoverview[] Returns an array of Collaboratedlabscreenprojectoverview objects
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
    public function findOneBySomeField($value): ?Collaboratedlabscreenprojectoverview
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
