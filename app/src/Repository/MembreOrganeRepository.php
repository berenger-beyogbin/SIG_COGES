<?php

namespace App\Repository;

use App\Entity\MembreOrgane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MembreOrgane>
 *
 * @method MembreOrgane|null find($id, $lockMode = null, $lockVersion = null)
 * @method MembreOrgane|null findOneBy(array $criteria, array $orderBy = null)
 * @method MembreOrgane[]    findAll()
 * @method MembreOrgane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembreOrganeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembreOrgane::class);
    }

    public function add(MembreOrgane $entity, bool $flush = false): void
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
        $data = $this->createQueryBuilder('m')
            ->select('m.id, m.nom as text')
            ->andWhere("m.nom LIKE '$libelle%'")
            ->getQuery()
            ->getResult()
        ;

        return $data;
    }
//    /**
//     * @return MembreOrgane[] Returns an array of MembreOrgane objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MembreOrgane
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
