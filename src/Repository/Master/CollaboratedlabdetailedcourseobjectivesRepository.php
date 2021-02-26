<?php

namespace App\Repository\Master;

use App\Entity\Master\Collaboratedlabdetailedcourseobjectives;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaboratedlabdetailedcourseobjectives|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboratedlabdetailedcourseobjectives|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboratedlabdetailedcourseobjectives[]    findAll()
 * @method Collaboratedlabdetailedcourseobjectives[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedlabdetailedcourseobjectivesRepository  extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, Collaboratedlabdetailedcourseobjectives::class);
    // }

    // /**
    //  * @return Collaboratedlabdetailedcourseobjectives[] Returns an array of Collaboratedlabdetailedcourseobjectives objects
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
    public function findOneBySomeField($value): ?Collaboratedlabdetailedcourseobjectives
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
