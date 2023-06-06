<?php

namespace App\Repository;

use App\Entity\MasterclassLvl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MasterclassLvl>
 *
 * @method MasterclassLvl|null find($id, $lockMode = null, $lockVersion = null)
 * @method MasterclassLvl|null findOneBy(array $criteria, array $orderBy = null)
 * @method MasterclassLvl[]    findAll()
 * @method MasterclassLvl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasterclassLvlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MasterclassLvl::class);
    }

    public function save(MasterclassLvl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MasterclassLvl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MasterclassLvl[] Returns an array of MasterclassLvl objects
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

//    public function findOneBySomeField($value): ?MasterclassLvl
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
