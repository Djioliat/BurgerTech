<?php

    namespace App\Controller;

    use App\Entity\Comment;
    use App\Form\CommentType;
    use App\Repository\EpisodeRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Knp\Component\Pager\PaginatorInterface;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    
    use Symfony\Component\HttpFoundation\Request;

    #[Route('/episode', name: 'episode_')]
    class EpisodeController extends AbstractController
    {
        #[Route('/', name: 'index')]
        public function index(EpisodeRepository $episodeRepository, Request $request, PaginatorInterface $paginator): Response
        {
            $data = $episodeRepository->findAll();
            
            $episode = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                4
            );
            return $this->render('episode/index.html.twig', 
            [
                'episode' => $episode
            ]);
        }

        #[Route('/{slug}', name:('detail'))]
        public function details ($slug, EpisodeRepository $episode, EntityManagerInterface $entityManager, Request $request): Response
        {
            // Afficher l'épisode
            $episode = $episode->findOneBy(['slug' => $slug]);

            // Traitement du formulaire

            $comment = new Comment();
    
            $commentForm = $this->createForm(CommentType::class, $comment);
        
            $commentForm->handleRequest($request);
            
            if($commentForm->isSubmitted() && $commentForm->isValid()){

                $comment->setEpisode($episode);
                
                $entityManager->persist($comment);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                "Le commentaire {$comment->getContent()} a bien été enregistrée"
            );
             
            return $this->redirectToRoute('episode_detail', ['slug' => $episode->getSlug()]);
            
        }
            //

            return $this->render('episode/detail.html.twig', [
                'episode' => $episode,
                'commentForm' => $commentForm->createView()
            ]);
        }
    }

