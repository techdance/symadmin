<?php

namespace App\Repository\Master;

use App\Entity\Master\MasterLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MasterLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method MasterLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method MasterLanguage[]    findAll()
 * @method MasterLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasterLanguageRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, MasterLanguage::class);
    // }

    // /**
    //  * @return MasterLanguage[] Returns an array of MasterLanguage objects
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
    public function findOneBySomeField($value): ?MasterLanguage
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
