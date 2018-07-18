<?php

namespace App\Repository;

use App\Entity\ViewType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ViewType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewType[]    findAll()
 * @method ViewType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ViewType::class);
    }

//    /**
//     * @return ViewType[] Returns an array of ViewType objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ViewType
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
