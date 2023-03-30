<?php

namespace App\Repository;

use App\Entity\AssistantTreatment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssistantTreatment>
 *
 * @method AssistantTreatment|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssistantTreatment|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssistantTreatment[]    findAll()
 * @method AssistantTreatment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssistantTreatmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssistantTreatment::class);
    }

    public function save(AssistantTreatment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AssistantTreatment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AssistantTreatment[] Returns an array of AssistantTreatment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AssistantTreatment
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
