<?php

namespace App\Repository;

use App\Entity\Gratification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gratification>
 *
 * @method Gratification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gratification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gratification[]    findAll()
 * @method Gratification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GratificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gratification::class);
    }

    public function save(Gratification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gratification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
