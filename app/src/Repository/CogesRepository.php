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
    public function add(Coges $entity, bool $flush = false): void
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
//     * @return COGES[] Returns an array of COGES objects
//     */

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
