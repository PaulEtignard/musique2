<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;
    private PaginatorInterface $paginator;

    /**
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
         $this->articleRepository = $articleRepository;
    }


    #[Route('/articles', name: 'app_articles')]
    public function getAricles(PaginatorInterface $paginator, Request $request): Response
    {

        $articles = $paginator->paginate
        (
            $this->articleRepository->findBy([],["createAt"=>"DESC"]),
            $request->query->getInt("page",1),
            10
        );
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
