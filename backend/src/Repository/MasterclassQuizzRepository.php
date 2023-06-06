<?php

namespace App\Repository;

use App\Entity\MasterclassQuizz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MasterclassQuizz>
 *
 * @method MasterclassQuizz|null find($id, $lockMode = null, $lockVersion = null)
 * @method MasterclassQuizz|null findOneBy(array $criteria, array $orderBy = null)
 * @method MasterclassQuizz[]    findAll()
 * @method MasterclassQuizz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasterclassQuizzRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MasterclassQuizz::class);
    }

    public function save(MasterclassQuizz $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MasterclassQuizz $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MasterclassQuizz[] Returns an array of MasterclassQuizz objects
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

//    public function findOneBySomeField($value): ?MasterclassQuizz
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
