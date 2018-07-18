<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 7/4/18
 * Time: 4:52 PM
 */

namespace App\Service;


use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\UzPostRepository;

class PostManager
{
    private $uzPostRepository;

    private $postRepository;

    public function __construct(PostRepository $postRepository, UzPostRepository $uzPostRepository)
    {
        $this->postRepository = $postRepository;
        $this->uzPostRepository = $uzPostRepository;
    }

    /**
     * @param string $locale
     * @param int $page
     * @return Post[]|\App\Repository\Post|\App\Repository\Post[]|null
     */
    public function loadAllLatestPostsByLocaleAndPage(string $locale, int $page)
    {
        if($locale == 'ru')
        {

            $posts = $this->postRepository->findAllLatestPostsByPage($page);

            return $posts;
        }
        if($locale == 'uz')
        {

            $posts = $this->uzPostRepository->findAllLatestPostsByPage($page);

            return $posts;
        }
    }


    /**
     * @param string $locale
     * @param string $slug
     * @return Post|\App\Repository\Post|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadPostByLocaleAndSlug(string $locale, string $slug)
    {
        if($locale == 'ru') {

            $posts = $this->postRepository->findPostBySlug($slug);

            return $posts;
        }
        if($locale == 'uz')
        {

            $posts = $this->uzPostRepository->findPostBySlug($slug);

            return $posts;
        }
    }


    /**
     * @param string $locale
     * @param string $category
     * @param int $page
     * @return Post[]|\App\Repository\Post|\App\Repository\Post[]|null
     */
    public function loadPostsByLocaleAndCategoryAndPage(string $locale, string $category, int $page)
    {
        if($locale == 'ru') {

            $posts = $this->postRepository->findPostsByCategory($category, $page);

            return $posts;
        }
        if($locale == 'uz')
        {

            $posts = $this->uzPostRepository->findPostsByCategory($category, $page);

            return $posts;
        }
    }


    /**
     * @param string $locale
     * @return \App\Repository\Post|array|null
     */
    public function loadFamousPostsByLocale(string $locale)
    {
        if($locale == 'ru') {

            $posts = $this->postRepository->getFamousPosts();

            return $posts;
        }
        if($locale == 'uz')
        {
            $posts = $this->uzPostRepository->getFamousPosts();

            return $posts;
        }
    }

    /**
     * @param string $locale
     * @param Post $post
     * @return Post[]|array
     */
    public function loadSimilarPostsByLocaleAndTags(string $locale, Post $post)
    {
        if($locale == 'ru') {

            $posts = [];
            foreach ($post->getTags() as $tag) {
                $posts = $this->postRepository->getSimilarPostsByTagName($tag->getName(), $post->getId());
            }

            if(count($posts) > 4) {
                $posts = array_slice($posts, 0, 4);
            }

            return $posts;
        }
        if($locale == 'uz')
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
    }



    public function loadPostsByLocaleAndTextAndPage(string $locale, string $text, int $page)
    {
        if($locale == 'ru') {

            $posts = $this->postRepository->findPostsByTextAndPage($text, $page);

            return $posts;
        }
        if($locale == 'uz')
        {
            $posts = $this->uzPostRepository->findPostsByTextAndPage($text, $page);

            return $posts;
        }
    }

}