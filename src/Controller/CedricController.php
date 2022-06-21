<?php

namespace App\Controller;

use App\Entity\Cedric;
use App\Form\CedricType;
use App\Repository\CedricRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CedricController extends AbstractController
{
    #[Route('/cedric', name: 'app_cedric')]
    public function index(CedricRepository $cedricRepository): Response
    {
        return $this->render('cedric/index.html.twig', 
        [
            'cedric' => $cedricRepository->findBy([],[
                'id' => 'DESC'
            ])
        ]);
    }

    #[Route('/cedric/new', name:'app_new')]
    public function create(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $art = new Cedric();

        $form = $this->createForm(CedricType::class, $art);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManagerInterface->persist($art);
            $entityManagerInterface->flush();

        return $this->redirectToRoute('app_cedric');
        }
        return $this->render('cedric/new.html.twig',[
            'form' => $form->createView()
            ]);
    }
}
