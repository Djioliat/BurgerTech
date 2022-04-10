<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Repository\EpisodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EpisodeController extends AbstractController
{
    #[Route('/episodes', name: 'episode')]
    public function index(EpisodeRepository $repo): Response
    {
        $repo->getRepository(Episode::class);


        return $this->render('episode/index.html.twig', [
            'episodes' => $repo->findAll(),
        ]);
    }
}
