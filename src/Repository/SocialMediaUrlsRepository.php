<?php

namespace App\Repository;

use App\Entity\SocialMediaUrls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocialMediaUrls|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocialMediaUrls|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocialMediaUrls[]    findAll()
 * @method SocialMediaUrls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocialMediaUrlsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialMediaUrls::class);
    }

    // /**
    //  * @return SocialMediaUrls[] Returns an array of SocialMediaUrls objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SocialMediaUrls
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
