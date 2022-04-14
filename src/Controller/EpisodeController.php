<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Repository\EpisodeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/episode', name: 'episode_')]
class EpisodeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EpisodeRepository $episodeRepository): Response
    {
        return $this->render('episode/index.html.twig', [
        'episode' => $episodeRepository->findAll()
        ]);
    }

    #[Route('/{slug}', name:('detail'))]
    public function details(Episode $episode): Response
    {
        return $this->render('episode/detail.html.twig', compact('episode'));
    }
}
