<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EpisodeRepository;

class FluxrssController extends AbstractController
{
    /**
     * @Route("/adpmrss.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request, EpisodeRepository $episodeRepository): Response
    {
        // Récupérer hôte depuis l'url
        $hostname = $request->getSchemeAndHttpHost('episode_detail');
        
        $urls = [];

        // Url dynamique
        $episodes = $episodeRepository->findAll();

        foreach($episodes as $episode){

            $urls[] = [
                'loc' => $this->generateUrl('episode_detail', [ 
                    'slug' => $episode->getSlug()
                ]),
                'title' => $episode->getTitle(),
                'images' => $episode->getCoverImage(),
                'audio'=> $episode->getAudio(),
                'content' => $episode->getContent(),
                'pubDate' => $episode->getCreatedAt(),
            ];
        }
        // Fabriquer la réponse 
        $response = new Response(
            $this->renderView('adpmrss_xml/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname
            ]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
