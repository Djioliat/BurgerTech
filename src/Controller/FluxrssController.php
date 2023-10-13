<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EpisodeRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FluxrssController extends AbstractController
{
    /**
     * @Route("/adpmrss.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request, EpisodeRepository $episodeRepository): Response
    {
        // Récupérer hôte depuis l'url
        $hostname = $request->getSchemeAndHttpHost();
        
        $urls = [];

        // Url dynamique
        $episodes = $episodeRepository->findAll();

        foreach ($episodes as $episode) {
            $audioUrl = $episode->getAudio();
            $length = $this->getRemoteFileSize($audioUrl);
            $duration = $this->getAudioDuration($audioUrl);

            $urls[] = [
                'loc' => $this->generateUrl('episode_detail', [ 
                    'slug' => $episode->getSlug()
                ], UrlGeneratorInterface::ABSOLUTE_URL),
                'title' => $episode->getTitle(),
                'images' => $episode->getCoverImage(),
                'audio' => $audioUrl,
                'content' => $episode->getContent(),
                'pubDate' => $episode->getCreatedAt(),
                'length' => $length,
                'LastPublishDate' => $episode->getPublishDate(),
                'duration' => $duration,
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

    /**
     * @param string $url 
     * @return int|null 
     */
    private function getRemoteFileSize(string $url): ?int
    {
        $headers = get_headers($url, 1);

        // Vérifier si la requête a réussi (200 OK)
        if (isset($headers['Content-Length']) && is_numeric($headers['Content-Length'])) {
            return (int) $headers['Content-Length'];
        }

        return null;
    }

    /**
     * @param string $url 
     * @return int|null 
     */
    private function getAudioDuration(string $url): ?int
    {
        // Vous devez implémenter une logique pour obtenir la durée du fichier audio
        // par exemple, en utilisant une bibliothèque externe comme getID3 ou une autre méthode appropriée pour votre cas.
        // La fonction actuelle retourne null, vous devez adapter cela à votre besoin spécifique.

        return null;
    }
}
