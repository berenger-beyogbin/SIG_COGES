<?php

namespace App\Repository;

use App\Entity\Dren;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dren>
 *
 * @method Dren|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dren|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dren[]    findAll()
 * @method Dren[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dren::class);
    }

    public function add(Dren $entity, bool $flush = false): void
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
//     * @return Dren[] Returns an array of Dren objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dren
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
