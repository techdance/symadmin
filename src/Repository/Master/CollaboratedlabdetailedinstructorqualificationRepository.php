<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedlabdetailedinstructorqualification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedlabdetailedinstructorqualification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedlabdetailedinstructorqualification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedlabdetailedinstructorqualification[]    findAll()
 * @method Collaboratedlabdetailedinstructorqualification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedlabdetailedinstructorqualificationRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedlabdetailedinstructorqualification::class);
    // }

    // /**
    //  * @return Collaboratedlabdetailedinstructorqualification[] Returns an array of Collaboratedlabdetailedinstructorqualification objects
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
    public function findOneBySomeField($value): ?Collaboratedlabdetailedinstructorqualification
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
