<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $comment = new Comment();
        $comment->setAuthor('Gérard');
        $comment->setContent('Un super épisode');
    
        $manager->persist($comment);

        $manager->flush();
    }
}
