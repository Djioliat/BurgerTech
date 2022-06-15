<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Episode;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Jeux de fausse donnée 
        for($i =1; $i <= 20; $i++){

        $episode = new Episode();  
        $episode->setTitle("Episode")
                ->setCoverImage("https://www.burgertech.fr/images/2022-03-28_145_team_burgertech_-_ca_craint1.jpg")
                ->setIntroduction("Introduction")
                ->setContent("Contenue de l'annonce")
                ->setAudio("https://www.burgertech.fr/media/2022-03-28_145_team_burgertech_-_ca_craint1.mp3");
        $manager->persist($episode);

        // Commentaire
        for($k = 1; $k <= 5; $i++){
            $comment = new Comment();
            $comment->setAuthor("Michel")
                ->setContent("Un super épisode")
                ->setEpisode($episode);
        }
        }

        $manager->flush();
    }
}
