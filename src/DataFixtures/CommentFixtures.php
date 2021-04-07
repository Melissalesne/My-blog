<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i <= 10; $i++){
         // Créer un commentaire
       $comment = new Comment();
       $comment->setContent("Ceci est un commentaire");
       $comment->setAuthor("Mélissa");
       $comment->setCreatedAt(new \DateTime());
       $comment->setArticle($this->getReference('article-1'));

       $manager->persist($comment);
        }
       

        $manager->flush();
    }
}
