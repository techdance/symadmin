<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedlabdetailedlearningenvironments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedlabdetailedlearningenvironments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedlabdetailedlearningenvironments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedlabdetailedlearningenvironments[]    findAll()
 * @method Collaboratedlabdetailedlearningenvironments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedlabdetailedlearningenvironmentsRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedlabdetailedlearningenvironments::class);
    // }

    // /**
    //  * @return Collaboratedlabdetailedlearningenvironments[] Returns an array of Collaboratedlabdetailedlearningenvironments objects
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
    public function findOneBySomeField($value): ?Collaboratedlabdetailedlearningenvironments
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
