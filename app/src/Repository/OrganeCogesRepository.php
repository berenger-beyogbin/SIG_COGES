<?php

namespace App\Repository;

use App\Entity\OrganeCoges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrganeCoges>
 *
 * @method OrganeCoges|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganeCoges|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganeCoges[]    findAll()
 * @method OrganeCoges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganeCogesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganeCoges::class);
    }

    public function add(OrganeCoges $entity, bool $flush = false): void
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
//     * @return OrganeCoges[] Returns an array of OrganeCoges objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrganeCoges
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
