<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Form\CommentType;
use App\Repository\EpisodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/episode', name: 'episode_')]
class EpisodeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EpisodeRepository $episodeRepository): Response
    {
        return $this->render('episode/index.html.twig', [
        'episode' => $episodeRepository->findBy([],
        ['id' => 'DESC'])
        ]);
    }

    #[Route('/{slug}', name:('detail'))]
    public function details(Episode $episode): Response
    {
        return $this->render('episode/detail.html.twig', compact('episode'));
    }

    #[Route('/{slug}/comment', name:('commentaire'))]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Le commentaire {$comment->getContent()} a bien été enregistrée"
            );
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/ajout.html.twig',[
        'form' => $form->createView()
        ]);

    }
}

