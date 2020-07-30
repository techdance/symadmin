<?php

namespace App\Repository;

use App\Entity\InstitutionAcademicDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InstitutionAcademicDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionAcademicDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionAcademicDetails[]    findAll()
 * @method InstitutionAcademicDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionAcademicDetailsRepository extends \Doctrine\ORM\EntityRepository
{
    
}
