<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\ArticlesRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{   
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/utilisateurs', name: 'utilisateurs')]
    public function usersList(UsersRepository $users){

        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);

    }
    #[Route('/utilisateur/modifier/{id}', name: 'modifier_utilisateur')]
    public function editUser(Users $user, Request $request, EntityManagerInterface $entityManager)
    {
        $form =$this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/edituser.html.twig', [
            'user' => $user,
            'userForm' => $form->createView()
        ]);
    }
    #[Route('/utilisateur/supprimer/{id}', name: 'delete_utilisateur')]
    public function delete(Users $user,EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', "L'utilisateur {$user->getPseudo()} à bien été supprimé !");
        return $this->redirectToRoute('admin_utilisateurs');    
    }

    #[Route('/preparation', name: 'preparation')]
    public function preparation(ArticlesRepository $articles): Response
    {
        $auteurs = ['alex', 'dk', 'morgan', 'john'];

        $data = $articles->createQueryBuilder('a')
            ->where('a.auteur IN (:auteurs)')
            ->setParameter('auteurs', $auteurs)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('admin/preparation.html.twig', [
            'articles' => $data
    ]);
    }

}
