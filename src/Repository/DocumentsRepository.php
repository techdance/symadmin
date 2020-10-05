<?php

namespace App\Repository;

use App\Entity\Documents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Settings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Settings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentsRepository extends \Doctrine\ORM\EntityRepository
{
     public function findById(int $id) 
    { 
        $qb = $this->createQueryBuilder('documents');
                    
                   
                    // ->where('ins_prof.id = :id')
                    // ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); 
    }
}
