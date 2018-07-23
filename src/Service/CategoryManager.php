<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 7/6/18
 * Time: 4:47 PM
 */

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\UzCategoryRepository;

class CategoryManager
{
    private $categoryRepository;

    private $uzCategoryRepository;

    public function __construct(CategoryRepository $categoryRepository, UzCategoryRepository $uzCategoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->uzCategoryRepository = $uzCategoryRepository;
    }

    public function loadCategoriesByLocale($locale)
    {
        if ($locale == 'ru') {
            $categories = $this->categoryRepository->getCategories();


            return $categories;
        }
        if ($locale == 'uz') {
            $categories = $this->uzCategoryRepository->getCategories();

            return $categories;
        }
    }
}
