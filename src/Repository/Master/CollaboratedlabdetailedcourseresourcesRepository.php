<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedlabdetailedcourseresources;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedlabdetailedcourseresources|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedlabdetailedcourseresources|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedlabdetailedcourseresources[]    findAll()
 * @method Collaboratedlabdetailedcourseresources[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedlabdetailedcourseresourcesRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedlabdetailedcourseresources::class);
    // }

    // /**
    //  * @return Collaboratedlabdetailedcourseresources[] Returns an array of Collaboratedlabdetailedcourseresources objects
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
    public function findOneBySomeField($value): ?Collaboratedlabdetailedcourseresources
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
