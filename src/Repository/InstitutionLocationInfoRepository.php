<?php

namespace App\Repository;

use App\Entity\InstitutionLocationInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InstitutionLocationInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionLocationInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionLocationInfo[]    findAll()
 * @method InstitutionLocationInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionLocationInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstitutionLocationInfo::class);
    }

    // /**
    //  * @return InstitutionLocationInfo[] Returns an array of InstitutionLocationInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InstitutionLocationInfo
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
