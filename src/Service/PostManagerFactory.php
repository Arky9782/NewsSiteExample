<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 7/20/18
 * Time: 4:25 PM
 */

namespace App\Service;

use App\Repository\PostRepository;
use App\Repository\UzPostRepository;

class PostManagerFactory
{
    private $postRepository;

    private $uzPostRepository;

    public function __construct(PostRepository $postRepository, UzPostRepository $uzPostRepository)
    {
        $this->postRepository = $postRepository;

        $this->uzPostRepository = $uzPostRepository;
    }

    public function getPostManagerByLocale(string $locale)
    {
        try {
            switch ($locale) {
                case "ru":

                    return new PostManager($this->postRepository);

                case "uz":
                    return new PostManager($this->uzPostRepository);

                default:
                    throw new \Exception("Unknown locale");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
