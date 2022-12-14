<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\ProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'profil_index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('/profil/modifier/{id}', name: 'profil_modif')]
    public function edit(Users $user, Request $request): Response
    {
        if ($this->getUser() !== $user) {
            throw new AccessDeniedException("Vous n'avez pas l'autorisation de modifier ce compte.");
        }
        $user = $user->getId();
        $form = $this->createForm(ProfileEditType::class);
        $form->handleRequest($request);


        return $this->render('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/profil/supprimer/{id}', name: 'profil_delete')]
    public function delete(Users $user, EntityManagerInterface $manager): Response
    {
        if ($this->getUser() !== $user) {
            throw new AccessDeniedException("Vous n'avez pas l'autorisation de supprimer ce compte.");
        }
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', "L'utilisateur à bien été supprimé !");

        return $this->redirectToRoute('app_home'); 
          
    }
}
