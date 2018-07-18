<?php

namespace App\Controller;

use App\Entity\ExchangeRate;
use App\Service\CategoryManager;
use App\Service\PostManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/{page}", name="index", requirements={"page"="\d+"})
     */
    public function index(CategoryManager $cm, PostManager $pm, Request $request, $page = 0)
    {
        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $posts = $pm->loadAllLatestPostsByLocaleAndPage($locale, $page);

        $categories = $cm->loadCategoriesByLocale($locale);

        if ($request->isXmlHttpRequest()){
            if($posts) {
                return $this->render('default/posts.html.twig', [
                    'posts' => $posts,
                    'locale' => $locale,
                ]);
            }
            else {
                return new Response(null, 404);
            }
        }

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
            'locale' => $locale,
            'rates' => $rates,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/post/{slug}", name="show")
     */
    public function showPost(CategoryManager $cm, PostManager $pm, $slug, Request $request)
    {
        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $post = $pm->loadPostByLocaleAndSlug($locale, $slug);
        $categories = $cm->loadCategoriesByLocale($locale);
        $famousPosts = $pm->loadFamousPostsByLocale($locale);

        $similarPosts = $pm->loadSimilarPostsByLocaleAndTags($locale, $post);

        return $this->render('default/show.html.twig', [
            'post' => $post,
            'locale' => $locale,
            'rates'  => $rates,
            'famousPosts' => $famousPosts,
            'similarPosts' => $similarPosts,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{category}/{page}", name="get_category_posts")
     */
    public function getPostsByCategory(CategoryManager $cm, Request $request, $category , PostManager $pm, $page = 0)
    {
        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $categories = $cm->loadCategoriesByLocale($locale);

        $posts = $pm->loadPostsByLocaleAndCategoryAndPage($locale, $category, $page);

        if ($request->isXmlHttpRequest()){

            if($posts) {
                return $this->render('default/posts.html.twig', [
                    'posts' => $posts,
                    'locale' => $locale,
                    'category' => $category,
                ]);
            }
            else {
                return new Response(null, 404);
            }
        }

        return $this->render('default/category.html.twig', [
            'posts' => $posts,
            'locale' => $locale,
            'rates' => $rates,
            'category' => $category,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/search/{page}", name="search")
     * @Method({"post"})
     */
    public function search(Request $request, PostManager $pm, CategoryManager $cm, $page = 0)
    {
        $text = $request->get('search');

        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $categories = $cm->loadCategoriesByLocale($locale);

        $posts = $pm->loadPostsByLocaleAndTextAndPage($locale, $text, $page);

        if ($request->isXmlHttpRequest()){

            if($posts) {
                return $this->render('default/posts.html.twig', [
                    'posts' => $posts,
                    'locale' => $locale,
                    'text' => $text,
                ]);
            }
            else {
                return new Response(null, 404);
            }
        }

        return $this->render('default/search.html.twig', [
            'locale' => $locale,
            'posts' => $posts,
            'categories' => $categories,
            'rates' => $rates,
            'text' => $text,
        ]);
    }
}
