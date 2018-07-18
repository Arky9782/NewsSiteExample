<?php

namespace App\Repository;

use App\Entity\UzCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UzCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UzCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UzCategory[]    findAll()
 * @method UzCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UzCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UzCategory::class);
    }

    public function getCategories()
    {
        $result = $this->createQueryBuilder('c')
            ->orderBy('c.id')
            ->getQuery()
            ->getResult();

        return $result;

    }


//    /**
//     * @return UzCategory[] Returns an array of UzCategory objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UzCategory
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
