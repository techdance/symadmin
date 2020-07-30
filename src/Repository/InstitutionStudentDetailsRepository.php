<?php

namespace App\Repository;

use App\Entity\InstitutionStudentDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InstitutionStudentDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionStudentDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionStudentDetails[]    findAll()
 * @method InstitutionStudentDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionStudentDetailsRepository extends \Doctrine\ORM\EntityRepository
{
    
}
