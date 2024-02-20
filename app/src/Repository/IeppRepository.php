<?php

namespace App\Repository;

use App\Entity\Iepp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Iepp>
 *
 * @method Iepp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Iepp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Iepp[]    findAll()
 * @method Iepp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IeppRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Iepp::class);
    }

    public function add(Iepp $entity, bool $flush = false): void
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

    public function findAllAjaxSelect2($libelle): array
    {
        $data = $this->createQueryBuilder('c')
            ->select('c.id, c.libelle as text')
            ->andWhere("c.libelle LIKE '%$libelle%'")
            ->getQuery()
            ->getResult()
        ;

        return $data;
    }


//    /**
//     * @return Iepp[] Returns an array of Iepp objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Iepp
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
