<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       // Créer un nouvel article
       for($i= 1; $i <= 10;$i++){
        $article = new Article();
        $article->setTitle("Article n°".$i);
        $article->setContent("Ceci est le contenu dde l'article");

        $date = new \DateTime();
        // Modifie la date
        $date->modify('-'.$i.' days');
        $article->setCreatedAt($date);
        
        $this->addReference('article-'.$i, $article);
        
        $manager->persist($article);
       }
     
        $manager->flush();
    }
}
