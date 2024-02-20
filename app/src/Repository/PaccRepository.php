<?php

namespace App\Repository;

use App\Entity\Pacc;
use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pacc>
 *
 * @method Pacc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pacc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pacc[]    findAll()
 * @method Pacc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaccRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pacc::class);
    }

    public function add(Pacc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
//    /**
//     * @return Pacc[] Returns an array of Pacc objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pacc
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
