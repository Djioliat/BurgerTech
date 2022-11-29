<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Form\CommentType;
use App\Form\ArticleNewType;
use App\Repository\CommentRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class EpisodeController extends AbstractController
{

    #[Route('/episode', name: 'episode_index')]
    public function index(EpisodeRepository $episodeRepository, Request $request, PaginatorInterface $paginator): Response
        {
            $data = $episodeRepository->findBy(
                [],
                ['id' => 'DESC']
            );
            $episodes = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                3
            );
            return $this->render('episode/index.html.twig', 
            [
                'episode' => $episodes
            ]);
        }

    #[Route('/episode/{slug}', name:('episode_detail'))]
    public function details($slug,ArticlesRepository $articleRepository,CommentRepository $comment, EpisodeRepository $episode, EntityManagerInterface $entityManager, Request $request): Response
        {
            // Afficher l'épisode
            $episode = $episode->findOneBy
            (
                [
                    'slug' => $slug
                ],
            );
           /*  $article = $articleRepository->findAll(
                [
                    'id' => 'DESC'
                ]
            );  */
            /* $comment = $comment->findAll(
                [
                    'id' => 'DESC'
                ]
                );
             */
            
            // Traitement du formulaire

            $comment = new Comment();
            $commentForm = $this->createForm(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if($commentForm->isSubmitted() && $commentForm->isValid())
            {
                $comment->setEpisode($episode);
                $comment->setUsers($this->getUser()); 
                $entityManager->persist($comment);
                $entityManager->flush();

                $this->addFlash
                (
                    'success',
                    "Le commentaire {$comment->getContent()} a bien été enregistrée"
                );      
            }
            return $this->render('episode/detail.html.twig', [
                'episode' => $episode,
                'commentForm' => $commentForm->createView()
                ]);
        }
    #[Route('/episode/{slug}/edit', name:('episode_edit'))]
    public function edit(Episode $episode, Request $request, EntityManagerInterface $entityManager): Response
        {
            $form = $this->createForm(ArticleNewType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $entityManager->persist($episode);
                $entityManager->flush();
                //return $this->redirectToRoute('episode_edit');
            }
            return $this->renderForm('episode/edit.html.twig',
            [
                    'form' => $form,    
            ]);
        }         
            
}

