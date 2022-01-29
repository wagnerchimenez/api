<?php

namespace App\Repository;

use App\Entity\CourseRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourseRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseRegistration[]    findAll()
 * @method CourseRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseRegistration::class);
    }

    public function totalStudentsInCourse($courseId) : int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select count(c.id) as total
            from course_registration r
            join course c on c.id = r.course_id
            where c.id = :courseId
            group by c.id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['courseId' => $courseId]);

        return (int) $resultSet->fetchOne();
    }

    public function courseInProgressOrClosed($courseId, $date) : bool
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select count(*) as total
            from course c
            where
            :courseId = c.id and
            :date between c.start_date and c.end_date
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'courseId' => $courseId,
            'date'=> $date
        ]);

        $total = (int) $resultSet->fetchOne();

        return $total > 0 ? true : false;
    }

    public function studentAlreadyRegisteredInCourse($studentId, $courseId): bool
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select count(*) as total
            from course_registration r
            where r.student_id = :studentId and r.course_id = :courseId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'studentId' => $studentId,
            'courseId' => $courseId
        ]);

        $total = (int) $resultSet->fetchOne();

        return $total > 0 ? true : false;
    }

    // /**
    //  * @return CourseRegistration[] Returns an array of CourseRegistration objects
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
    public function findOneBySomeField($value): ?CourseRegistration
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
