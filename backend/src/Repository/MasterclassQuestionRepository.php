<?php

namespace App\Repository;

use App\Entity\MasterclassQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MasterclassQuestion>
 *
 * @method MasterclassQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method MasterclassQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method MasterclassQuestion[]    findAll()
 * @method MasterclassQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasterclassQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MasterclassQuestion::class);
    }

    public function save(MasterclassQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MasterclassQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MasterclassQuestion[] Returns an array of MasterclassQuestion objects
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

//    public function findOneBySomeField($value): ?MasterclassQuestion
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
