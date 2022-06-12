<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articlesRepository->findBy([],
            ['id' => 'DESC'])
        ]);
    }

    #[Route('/article/new', name: 'app_newArticle')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $art = new Articles();

        $form = $this->createForm(ArticleType::class, $art);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($art);
            $entityManager->flush();

        return $this->redirectToRoute('app_article');
        }
        return $this->render('article/new.html.twig',[
            'form' => $form->createView()
            ]);
    }

}