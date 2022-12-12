<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'profil_index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');

    }

    /* #[Route('/profil/supprimer', name: 'profil_delete')]
    public function delete(Users $user,EntityManagerInterface $manager): Response
    {
        $user = $this->getUser($user);
        $manager->remove($this->getUser($user));
        $manager->flush();

        $this->addFlash('success', "L'utilisateur à bien été supprimé !");

        return $this->redirectToRoute('home/index.html.twig', [
            'user' => $user
        ]); 
          
    } */
    #[Route('/profil/supprimer/{id}', name: 'profil_delete')]
    public function delete(int $id, EntityManagerInterface $manager): Response
    {
        $user = $manager->getRepository(Users::class)->find($id);
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', "L'utilisateur à bien été supprimé !");

        return $this->redirectToRoute('home/index.html.twig', [
            'user' => $user 
        ]); 
    }
}
