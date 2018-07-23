<?php

namespace App\Repository;

use App\Entity\UzPost;
use App\Interfaces\PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UzPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method UzPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method UzPost[]    findAll()
 * @method UzPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UzPostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UzPost::class);
    }

    /**
     * @param int $page
     * @return array
     */
    public function findAllLatestPostsByPage(int $page): array
    {
        $limit = 11;
        $start = $page * $limit;

        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.viewType', 'v')
            ->addSelect('v')
            ->where('p.draft = 0')
            ->orderBy('p.created_at', 'DESC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();

        return $qb->getResult();
    }

    /**
     * @param string $slug
     * @return Post|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findPostBySlug(string $slug): ?Post
    {
        return $this->createQueryBuilder('p')
            ->where('p.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleResult();
    }

    public function getLatestMainPost(): ?Post
    {
        $result = $this->createQueryBuilder('p')
                ->where('p.main = 1 AND p.draft = 0')
                ->orderBy('p.created_at', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

        return $result;
    }

    public function getFamousPosts(): array
    {
        $sql = 'SELECT * FROM post INNER JOIN author WHERE DATE(post.created_at) <= DATE_SUB(CURDATE(), INTERVAL 1 DAY) LIMIT 4';

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    /**
     * @param $tag
     * @param $id
     * @return Post[]
     */
    public function getSimilarPostsByTagName(string $tag, int $postId): array
    {
        $result = $this->createQueryBuilder('p')
            ->innerJoin('p.tags', 't')
            ->innerJoin('p.author', 'a')
            ->where('t.name = :tag')
            ->andWhere('p.id != :id')
            ->orderBy('p.created_at', 'DESC')
            ->setParameter('tag', $tag)
            ->setParameter('id', $postId)
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @param $category
     * @param $page
     * @return Post[]
     */
    public function findPostsByCategory(string $category, int $page): array
    {
        $limit = 11;
        $start = $page * $limit;

        $result = $this->createQueryBuilder('p')
            ->innerJoin('p.category', 'c')
            ->innerJoin('p.viewType', 'v')
            ->where('c.name = :category')
            ->setParameter('category', $category)
            ->orderBy('p.created_at', 'DESC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @param $text
     * @param $page
     * @return Post[]
     */
    public function findPostsByTextAndPage(string $text, int $page): array
    {
        $limit = 11;
        $start = $page * $limit;

        $result = $this->createQueryBuilder('p')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.viewType', 'v')
            ->addSelect('MATCH_AGAINST (p.title, :text) as score')
            ->add('where', 'MATCH_AGAINST(p.title, :text) > 0')
            ->setParameter('text', $text)
            ->orderBy('score', 'DESC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $posts = [];
        foreach ($result as $one) {
            unset($one['score']);
            $posts = $one;
        }

        return $posts;
    }

//    /**
//     * @return UzPost[] Returns an array of UzPost objects
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
    public function findOneBySomeField($value): ?UzPost
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
