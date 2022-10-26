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

#[Route('/article', name: 'article_')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articlesRepository->findBy
            (
                ['auteur' => 'public' ],
                ['id' => 'DESC']
            )
        ]);
    }

    #[Route('/new', name: 'new')]
    public function create( Request $request, EntityManagerInterface $entityManager): Response
    {
        $art = new Articles();

        $form = $this->createForm(ArticleType::class, $art);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($art);
            $entityManager->flush();
            
            return $this->redirectToRoute('article_index');
        }
        return $this->render('article/new.html.twig',[
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/cedric', name: 'cedric')]
    public function cedric(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('article/index.html.twig', 
        [
            'articles' => $articlesRepository->findBy(
            [
                'auteur' => 'cedric'
            ])
        ]);
    }

    #[Route('/gaetan', name: 'gaetan')]
    public function gaetan(ArticlesRepository $articlesRepository): Response
    {       
        return $this->render('article/index.html.twig', 
            [
                'articles' => $articlesRepository->findBy(
                [
                    'auteur' => 'gaetan' 
                ])
            ]);
    }

    #[Route('/{slug}/edit', name:'detail_edit')]
    public function edit(Articles $art, Request $request, EntityManagerInterface $entityManager): Response       
    {
        // Modifier annonce
        $form =$this->createForm(ArticleType::class, $art);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
            {
                $entityManager->persist($art);
                $entityManager->flush();
                
                return $this->redirectToRoute('article_index');
            }
            return $this->renderForm('article/edit.html.twig',
                [
                    'form' => $form,    
                ]);         
            }

    #[Route('/{slug}', name:'detail')]
    public function details($slug, ArticlesRepository $article, Request $request, Articles $art): Response
    {
        // Afficher article
        $article = $article->findOneBy(['slug' => $slug]);
   
        return $this->render('article/detail.html.twig', [
            'articles' => $article,
        ]);
    }
}