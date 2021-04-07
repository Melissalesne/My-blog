<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // Qui va lister l'ensemble des articles
    /**
     * @Route("/", name="liste_articles", methods={"GET"})
     */
    public function liste_articles(): Response
    {
    
        
        $articles = [
            [
                'nom' => 'Article 1',
                'id' => 1
                
            ],
            [
                'nom' => 'Article 2',
                'id' => 2
                
            ],
            [
                'nom' => 'Article 3',
                'id' => 3
            ],
            [
                'nom' => 'Article 4',
                'id' => 4
            ],
            [
                'nom' => 'Article 5',
                'id' => 5
            ]
        ];
       
        return $this->render('home/index.html.twig', [
            'articles' => $articles
        ]);
       
    }
    // Qui affichera un article
     /**
     * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function vueArticle($id) 
    {
        return $this->render('home/vue.html.twig', [
            'id' => $id
        ]);
    }
     
    // Qui permet d'ajouter des articles
    /**
     * @Route("/article/add", name="add_article")
     */
    public function add() 
    {
        
    }
}
