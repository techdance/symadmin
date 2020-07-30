<?php

namespace App\Repository;

use App\Entity\InstitutionContactInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InstitutionContactInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionContactInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionContactInfo[]    findAll()
 * @method InstitutionContactInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionContactInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstitutionContactInfo::class);
    }

    // /**
    //  * @return InstitutionContactInfo[] Returns an array of InstitutionContactInfo objects
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
    public function findOneBySomeField($value): ?InstitutionContactInfo
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
