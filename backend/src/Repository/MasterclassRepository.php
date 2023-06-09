<?php

namespace App\Repository;

use App\Entity\Masterclass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Masterclass>
 *
 * @method Masterclass|null find($id, $lockMode = null, $lockVersion = null)
 * @method Masterclass|null findOneBy(array $criteria, array $orderBy = null)
 * @method Masterclass[]    findAll()
 * @method Masterclass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasterclassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Masterclass::class);
    }

    public function save(Masterclass $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Masterclass $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findMasterclassByInstrument($id) {
        $return =  $this->createQueryBuilder('masterclass')
            ->andWhere('masterclass.Instrument = '. $id)
            ->getQuery()
            ->getResult();
        
        return $return;
    }

    public function findMasterclassByComposer($id) {
        $return =  $this->createQueryBuilder('masterclass')
            ->andWhere('masterclass.Composer = '. $id)
            ->getQuery()
            ->getResult();
        
        return $return;
    }

    public function findMasterclassByCentreDeFormation($id) {
        $return =  $this->createQueryBuilder('masterclass')
            ->andWhere('masterclass.user = '. $id)
            ->getQuery()
            ->getResult();
        
        return $return;
    }
}
