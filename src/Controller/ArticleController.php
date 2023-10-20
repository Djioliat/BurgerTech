<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    // Afficher les articles public
    #[Route('/article', name: 'article_index')]
    public function index(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $articlesRepository->findBy
        (
            ['auteur' => 'public' ],
            ['id' => 'DESC'],
        );
        $article = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('article/index.html.twig', [
            'articles' => $article
        ]);
    }
    // Article privé à un utilisateur
    #[Route('/article/dk', name: 'article_dk')]
    public function dk(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $articlesRepository->findBy(
            ['auteur' => 'dk'],
            ['id' => 'DESC'],
        );
        $article = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('article/index.html.twig', [
            'articles' => $article
        ]);
    }
    
    // Article privé à un utilisateur
    #[Route('/article/morgan', name: 'article_morgan')]
    public function morgan(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {      
        $data = $articlesRepository->findBy(
            ['auteur' => 'morgan'],
            ['id' => 'DESC']
        );
        $article = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            6
        );
        return $this->render('article/index.html.twig', 
            [
                'articles' => $article
            ]);
    }
    
    #[Route('/article/john', name: 'article_john')]
    public function john(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {      
        $data = $articlesRepository->findBy(
            ['auteur' => 'john'],
            ['id' => 'DESC']
        );
        $article = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            6
        );
        return $this->render('article/index.html.twig', 
            [
                'articles' => $article
            ]);
    }

    #[Route('/article/alex', name: 'article_alex')]
    public function alex(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {      
        $data = $articlesRepository->findBy(
            ['auteur' => 'alex'],
            ['id' => 'DESC']
        );
        $article = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            6
        );
        return $this->render('article/index.html.twig', 
            [
                'articles' => $article
            ]);
    }

    // Créer un article
    #[Route('/article/new', name: 'article_new')]
    public function create( Request $request, EntityManagerInterface $entityManager): Response
    {
        $art = new Articles();

        $form = $this->createForm(ArticleType::class, $art);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($art);
            $entityManager->flush();
            
            return $this->redirectToRoute('episode_index');
        }
        return $this->render('article/new.html.twig',[
            'form' => $form->createView()
        ]);
    }
    

    // Modifier un article
    #[Route('/article/{slug}/edit', name:'article_detail_edit')]
    public function edit(Articles $art, Request $request, EntityManagerInterface $entityManager): Response       
    {
        $form =$this->createForm(ArticleType::class, $art);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
            {
                $entityManager->persist($art);
                $entityManager->flush();
                
                return $this->redirectToRoute('episode_index');
            }
            return $this->render('article/edit.html.twig',
                [
                    'form' => $form,    
                ]);         
    }
    
    // Afficher un article
    #[Route('/article/{slug}', name:'article_detail')]
    public function details($slug, ArticlesRepository $article, Request $request, Articles $art): Response
    {
        $article = $article->findOneBy(['slug' => $slug]);
   
        return $this->render('article/detail.html.twig', [
            'articles' => $article,
        ]);
    }

    // Supprimer un article
    #[Route('/article/{slug}/delete', name:'article_delete')]
    public function delete(Articles $article, EntityManagerInterface $manager): Response
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('success',
        "L'annonce {$article->getTitle()} à bien été supprimée"
    );
        return $this->redirectToRoute("episode_index");
    }
}