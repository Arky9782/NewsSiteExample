<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 7/4/18
 * Time: 4:52 PM
 */

namespace App\Service;


use App\Entity\Post;
use App\Interfaces\PostRepositoryInterface;

class PostManager
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param int $page
     * @return array
     */
    public function loadAllLatestPostsByPage(int $page)
    {
            $posts = $this->postRepository->findAllLatestPostsByPage($page);

            return $posts;
    }


    /**
     * @param string $slug
     * @return Post|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadPostBySlug(string $slug)
    {
            $posts = $this->postRepository->findPostBySlug($slug);

            return $posts;
    }


    /**
     * @param string $category
     * @param int $page
     * @return array
     */
    public function loadPostsByCategoryAndPage(string $category, int $page)
    {
            $posts = $this->postRepository->findPostsByCategory($category, $page);

            return $posts;
    }


    /**
     * @param string $locale
     * @return array
     */
    public function loadFamousPosts()
    {
            $posts = $this->postRepository->getFamousPosts();

            return $posts;
    }

    /**
     * @param Post $post
     * @return array
     */
    public function loadSimilarPostsByTags(Post $post)
    {
            $posts = [];
            foreach ($post->getTags() as $tag) {
                $posts = $this->postRepository->getSimilarPostsByTagName($tag->getName(), $post->getId());
            }

            if(count($posts) > 4) {
                $posts = array_slice($posts, 0, 4);
            }

            return $posts;
    }


    /**
     * @param string $text
     * @param int $page
     * @return Post[]
     */
    public function loadPostsByTextAndPage(string $text, int $page)
    {
            $posts = $this->postRepository->findPostsByTextAndPage($text, $page);

            return $posts;
    }

}