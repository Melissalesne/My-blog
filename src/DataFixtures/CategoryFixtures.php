<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sport = new Category();
        $sport->setName('sport');

        // Ajouter plusieurs articles 
        $sport->addArticle($this->getReference('article-1'));
        $sport->addArticle($this->getReference('article-2'));
        $sport->addArticle($this->getReference('article-3'));

        $manager->persist($sport);

        $maison = new Category();
        $maison->setName('maison');

        $maison->addArticle($this->getReference('article-2'));
        $maison->addArticle($this->getReference('article-3'));
        $maison->addArticle($this->getReference('article-4'));

        $manager->persist($maison);

        $manager->flush();
    }

    // Rattacher les categories aux articles 
    public function getDependencies(){
        return [
            // Récupère la classe article 
            ArticleFixtures::class
        ];
    }
}
