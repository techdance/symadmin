<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedlabdetailedcoursehours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedlabdetailedcoursehours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedlabdetailedcoursehours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedlabdetailedcoursehours[]    findAll()
 * @method Collaboratedlabdetailedcoursehours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedlabdetailedcoursehoursRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedlabdetailedcoursehours::class);
    // }

    // /**
    //  * @return Collaboratedlabdetailedcoursehours[] Returns an array of Collaboratedlabdetailedcoursehours objects
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
    public function findOneBySomeField($value): ?Collaboratedlabdetailedcoursehours
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
