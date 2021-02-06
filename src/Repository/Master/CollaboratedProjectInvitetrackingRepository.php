<?php

namespace App\Repository\Master;

use App\Entity\Master\CollaboratedProjectInvitetracking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollaboratedProjectInvitetracking|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollaboratedProjectInvitetracking|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollaboratedProjectInvitetracking[]    findAll()
 * @method CollaboratedProjectInvitetracking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedProjectInvitetrackingRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, CollaboratedProjectInvitetracking::class);
    // }

    // /**
    //  * @return CollaboratedProjectInvitetracking[] Returns an array of CollaboratedProjectInvitetracking objects
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
    public function findOneBySomeField($value): ?CollaboratedProjectInvitetracking
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
