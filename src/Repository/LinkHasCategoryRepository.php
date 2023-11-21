<?php

namespace App\Repository;

use App\Entity\LinkHasCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkHasCategory>
 *
 * @method LinkHasCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkHasCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkHasCategory[]    findAll()
 * @method LinkHasCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @SuppressWarnings(BooleanArgumentFlag)
 */
class LinkHasCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkHasCategory::class);
    }

    public function add(LinkHasCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LinkHasCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return LinkHasCategory[] Returns an array of LinkHasCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LinkHasCategory
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
