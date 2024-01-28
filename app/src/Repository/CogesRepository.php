<?php

namespace App\Repository;

use App\Entity\Coges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coges>
 *
 * @method Coges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coges[]    findAll()
 * @method Coges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CogesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coges::class);
    }

//    /**
//     * @return COGES[] Returns an array of COGES objects
//     */
    public function findByDepartment($department): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.departement_id = :department')
            ->setParameter('department', $department)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?COGES
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
