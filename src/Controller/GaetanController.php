<?php

namespace App\Controller;

use App\Entity\Gaetan;
use App\Form\GaetanType;
use App\Repository\GaetanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GaetanController extends AbstractController
{
    #[Route('/gaetan', name: 'app_gaetan')]
    public function index(GaetanRepository $gaetanRepository): Response
    {
        return $this->render('gaetan/index.html.twig', [
            'gaetan' => $gaetanRepository->findBy([],[
                'id' => 'DESC'
            ])
        ]);
    }

    #[Route('/gaetan/new', name:'app_new')]
    public function create(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $art = new Gaetan();

        $form = $this->createForm(GaetanType::class, $art);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManagerInterface->persist($art);
            $entityManagerInterface->flush();

        return $this->redirectToRoute('app_gaetan');
        }
        return $this->render('gaetan/new.html.twig',[
            'form' => $form->createView()
            ]);
    }
}
