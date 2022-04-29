<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/author')]
class AuthorController extends AbstractController
{
    #[Route('/{id}', name: 'app_author_show', methods: ['GET'])]
    public function index(Author $author, SerializerInterface $serializer): Response
    {
        /*$id = $request->get('id');
        $article = $articleRepository->find($id);
        $author = new Author();
        $author->setFullname('Mantak CHia');
        $author->setBiography('Ma super biographie');
        $author->getArticles()->add($article);
        */

        $data = $serializer->serialize($author, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['list','details']]);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    #[Route('/', name: 'app_author_create')]
    public function createAuthor(Request $request, SerializerInterface $serializer, AuthorRepository $authorRepository)
    {
        $data = $request->getContent();
        $author = $serializer->deserialize($data, Author::class, 'json');
        $authorRepository->add($author);

        return new Response('', Response::HTTP_CREATED);
    }
}
