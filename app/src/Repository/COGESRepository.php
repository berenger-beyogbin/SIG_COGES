<?php

namespace App\Repository;

use App\Entity\COGES;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<COGES>
 *
 * @method COGES|null find($id, $lockMode = null, $lockVersion = null)
 * @method COGES|null findOneBy(array $criteria, array $orderBy = null)
 * @method COGES[]    findAll()
 * @method COGES[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class COGESRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, COGES::class);
    }

//    /**
//     * @return COGES[] Returns an array of COGES objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

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
