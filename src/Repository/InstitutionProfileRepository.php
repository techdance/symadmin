<?php

namespace App\Repository;

use App\Entity\InstitutionProfile;


/**
 * @method InstitutionProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionProfile[]    findAll()
 * @method InstitutionProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionProfileRepository extends \Doctrine\ORM\EntityRepository
{
    public function findById(int $id) 
    { 
        $qb = $this->createQueryBuilder('ins_prof')
                    ->select(['ins_prof, ins_con, ins_loc, std_det, faculty, aca_det, clgorschl, acc, recog, degree, social'])
                    ->join('ins_prof.institutionContact', 'ins_con')
                    ->join('ins_prof.institutionLocation', 'ins_loc')
                    ->join('ins_prof.studentDetails', 'std_det')
                    ->join('ins_prof.facultyDetails', 'faculty')
                    ->join('ins_prof.academicDetails', 'aca_det')
                    ->leftJoin('ins_prof.collegeSchools', 'clgorschl')
                    ->leftJoin('ins_prof.accrediations', 'acc')
                    ->leftJoin('ins_prof.recognitions', 'recog')
                    ->leftJoin('ins_prof.degrees', 'degree')
                    ->leftJoin('ins_prof.socialMedias', 'social');
                    // ->where('ins_prof.id = :id')
                    // ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); 
    }
}
