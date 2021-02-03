<?php

namespace App\Repository\Master;

use App\Entity\Master\CollaboratedLanguagePreferences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollaboratedLanguagePreferences|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollaboratedLanguagePreferences|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollaboratedLanguagePreferences[]    findAll()
 * @method CollaboratedLanguagePreferences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratedLanguagePreferencesRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, CollaboratedLanguagePreferences::class);
    // }

    // /**
    //  * @return CollaboratedLanguagePreferences[] Returns an array of CollaboratedLanguagePreferences objects
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
    public function findOneBySomeField($value): ?CollaboratedLanguagePreferences
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
