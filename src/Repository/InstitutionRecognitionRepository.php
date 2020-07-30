<?php

namespace App\Repository;

use App\Entity\InstitutionRecognition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InstitutionRecognition|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionRecognition|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionRecognition[]    findAll()
 * @method InstitutionRecognition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionRecognitionRepository extends \Doctrine\ORM\EntityRepository
{
    
}
