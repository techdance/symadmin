<?php

namespace App\Repository;

use App\Entity\InstitutionAccrediation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InstitutionAccrediation|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionAccrediation|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionAccrediation[]    findAll()
 * @method InstitutionAccrediation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionAccrediationRepository extends \Doctrine\ORM\EntityRepository
{
   
}
