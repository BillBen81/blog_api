<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


#[Route('/articles')]
class ArticleController extends AbstractController
{
    /*
    #[Route('/articles', name: 'app_article')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }
    */
    
    #[Route('/{id}', name: 'app_article_show')]
    #[ParamConverter('get', class: 'SensioBlogBundle')]
    public function showArticle(SerializerInterface $serializer, Request $request, ArticleRepository $articleRepository): Response
    {
        $id = $request->get('id');
        $article = $articleRepository->find($id);
        $data = $serializer->serialize($article, JsonEncoder::FORMAT);
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        return $response;
    }

    #[Route('/', name: 'app_article_create', methods: ['POST'])]
    public function creeerArticle(Request $request, SerializerInterface $serializer, ArticleRepository $articleRepository)
    {
        $data = $request->getContent();
        $article = $serializer->deserialize(
            $data,
            Article::class,
            JsonEncoder::FORMAT
        );
        $articleRepository->add($article);

        return new Response('', Response::HTTP_CREATED);
    }

    #[Route('/', name: 'app_article_list', methods: ['GET'])]
    public function listeArticles(SerializerInterface $serializer, ArticleRepository $articleRepository) : Response
    {
        $articles = $articleRepository->findAll();
        $data = $serializer->serialize($articles, JsonEncoder::FORMAT, SerializationContext::create()->setGroups(array('list')));
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        return $response;
    }

}
