<?php

namespace App\Repository\Master;

use App\Entity\Master\CommunicationPreferences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommunicationPreferences|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommunicationPreferences|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommunicationPreferences[]    findAll()
 * @method CommunicationPreferences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommunicationPreferencesRepository extends \Doctrine\ORM\EntityRepository
{
    // public function __construct(ManagerRegistry $registry)
    // {
    //     parent::__construct($registry, CommunicationPreferences::class);
    // }

    // /**
    //  * @return CommunicationPreferences[] Returns an array of CommunicationPreferences objects
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
    public function findOneBySomeField($value): ?CommunicationPreferences
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
