<?php

namespace App\Repository\Master;

use App\Entity\Master\MasterInstitutionLocationInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MasterInstitutionLocationInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method MasterInstitutionLocationInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method MasterInstitutionLocationInfo[]    findAll()
 * @method MasterInstitutionLocationInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasInstitutionLocationInfoRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, MasterInstitutionLocationInfo::class);
    // }

    // /**
    //  * @return MasterInstitutionLocationInfo[] Returns an array of MasterInstitutionLocationInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MasterInstitutionLocationInfo
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
