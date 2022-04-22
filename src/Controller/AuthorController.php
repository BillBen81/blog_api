<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author/{id}', name: 'app_author_show')]
    public function index(Article $article, ArticleRepository $articleRepository): Response
    {
        //$article = $articleRepository->findOneById(1);

        $article = $this->getDoctrine()->getRepository(Article::class)->findOneById(1);
        $author = new Author();
        $author->setFullname('Mantak CHia');
        $author->setBiography('Ma super biographie');
        $author->getArticles()->add($article);

        $data = null;

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
