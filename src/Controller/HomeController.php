<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Form\ArticleNewType;
use App\Repository\EpisodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EpisodeRepository $episodeRepository): Response
    {
        return $this->render('home/index.html.twig', [
        'episode' => $episodeRepository->findBy([],
        ['id' => 'DESC'])
        ]);
    }
    
    #[Route('/admin/ajout', name: 'app_ajout')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $epi = new Episode();

        $form = $this->createForm(ArticleNewType::class, $epi);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $entityManager->persist($epi);
        $entityManager->flush();

        $this->addFlash(
            'success',
            "L'annonce {$epi->getTitle()} a bien été enregistrée"
        );

        return $this->redirectToRoute('app_home');
        }
        return $this->render('home/ajout.html.twig',[
        'form' => $form->createView()
        ]);
    }
}
