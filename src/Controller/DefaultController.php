<?php

namespace App\Controller;

use App\Entity\ExchangeRate;
use App\Service\CategoryManager;
use App\Service\PostManagerFactory;
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
    public function index(CategoryManager $cm, PostManagerFactory $pmf, Request $request, $page = 0)
    {
        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $pm = $pmf->getPostManagerByLocale($locale);

        $posts = $pm->loadAllLatestPostsByPage($page);

        $categories = $cm->loadCategoriesByLocale($locale);

        if ($request->isXmlHttpRequest()) {
            if ($posts) {
                return $this->render('default/posts.html.twig', [
                    'posts' => $posts,
                    'locale' => $locale,
                ]);
            } else {
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
    public function showPost(CategoryManager $cm, PostManagerFactory $pmf, $slug, Request $request)
    {
        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $pm = $pmf->getPostManagerByLocale($locale);
        $post = $pm->loadPostBySlug($slug);
        $categories = $cm->loadCategoriesByLocale($locale);
        $famousPosts = $pm->loadFamousPosts();

        $similarPosts = $pm->loadSimilarPostsByTags($post);

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
    public function getPostsByCategory(CategoryManager $cm, Request $request, $category, PostManagerFactory $pmf, $page = 0)
    {
        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $categories = $cm->loadCategoriesByLocale($locale);

        $pm = $pmf->getPostManagerByLocale($locale);
        $posts = $pm->loadPostsByCategoryAndPage($category, $page);

        if ($request->isXmlHttpRequest()) {
            if ($posts) {
                return $this->render('default/posts.html.twig', [
                    'posts' => $posts,
                    'locale' => $locale,
                    'category' => $category,
                ]);
            } else {
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
    public function search(Request $request, PostManagerFactory $pmf, CategoryManager $cm, $page = 0)
    {
        $text = $request->get('search');

        $rateRepository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $rates = $rateRepository->getRates();

        $locale = $request->getLocale();

        $categories = $cm->loadCategoriesByLocale($locale);

        $pm = $pmf->getPostManagerByLocale($locale);
        $posts = $pm->loadPostsByTextAndPage($text, $page);

        if ($request->isXmlHttpRequest()) {
            if ($posts) {
                return $this->render('default/posts.html.twig', [
                    'posts' => $posts,
                    'locale' => $locale,
                    'text' => $text,
                ]);
            } else {
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
