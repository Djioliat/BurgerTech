<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\ProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'profil_index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('/profil/modifier/{id}', name: 'profil_modif')]
    public function edit(UserPasswordHasherInterface $userPasswordHasher, Users $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() !== $user) {
            throw new AccessDeniedException("Vous n'avez pas l'autorisation de modifier ce compte.");
        }
        
        $form = $this->createForm(ProfileEditType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
            {
                $user = $form->getData();
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('profil_index');
            }

        return $this->render('profil/edit.html.twig', [
            
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
