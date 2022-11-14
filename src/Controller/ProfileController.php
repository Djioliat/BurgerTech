<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/{pseudo}', name: 'index')]
    public function index(Users $user): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }
}
