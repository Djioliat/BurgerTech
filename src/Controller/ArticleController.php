<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManager;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article', name: 'article_')]
class ArticleController extends AbstractController
{
    // Afficher les articles public
    #[Route('/', name: 'index')]
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
            4
        );
        return $this->render('article/index.html.twig', [
            'articles' => $article
        ]);
    }
    // Article privé à un utilisateur
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
    
        // Article privé à un utilisateur
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
    

    // Créer un article
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
    

    // Modifier un article
    #[Route('/{slug}/edit', name:'detail_edit')]
    public function edit(Articles $art, Request $request, EntityManagerInterface $entityManager): Response       
    {
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
    
    // Afficher un article
    #[Route('/{slug}', name:'detail')]
    public function details($slug, ArticlesRepository $article, Request $request, Articles $art): Response
    {
        $article = $article->findOneBy(['slug' => $slug]);
   
        return $this->render('article/detail.html.twig', [
            'articles' => $article,
        ]);
    }

    // Supprimer un article
    #[Route('/{slug}/delete', name:'delete')]
    public function delete(Articles $article, EntityManagerInterface $manager): Response
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('success',
        "L'annonce {$article->getTitle()} à bien été supprimée"
    );
        return $this->redirectToRoute("article_index");
    }
}