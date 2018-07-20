<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 7/20/18
 * Time: 5:42 PM
 */

namespace App\Interfaces;


interface PostRepositoryInterface
{
    public function findAllLatestPostsByPage(int $page): array;

    public function findPostBySlug(string $slug);

    public function findPostsByCategory(string $category, int $page): array;

    public function getFamousPosts(): array;

    public function getSimilarPostsByTagName(string $tag, int $postId): array;

    public function findPostsByTextAndPage(string $text, int $page): array;
}