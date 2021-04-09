<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // Qui va lister l'ensemble des articles
    /**
     * @Route("/", name="liste_articles", methods={"GET"})
     */
    public function liste_articles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
       
        return $this->render('home/index.html.twig', [
            'articles' => $articles
        ]);
       
    }
    // Qui affichera un article
     /**
     * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function vueArticle(Article $article, Request $request, EntityManagerInterface $manager) 
    {
        // Créer l'objet Comment 
        $comment = new Comment();
        $comment->setArticle($article);
       

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('vue_article', ['id' => $article->getId()]);
        }
      

        return $this->render('home/vue.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
     
    // Qui permet d'ajouter des articles
    /**
     * @Route("/article/add", name="add_article")
     */
    public function add(Request $request, EntityManagerInterface $manager) 
    {
        // Créer une nouvel entité 
        $article = new Article();

         $form = $this->createForm(ArticleType::class, $article);
    
       $form->handleRequest($request);

       // Je verifie si le form est soumis et si il est valide
       if($form->isSubmitted() && $form->isValid()){

        $manager->persist($article);
        $manager->flush();

        return $this->redirectToRoute('liste_articles');
          
        // Créer un nouvel article 
           $article = new Article();
           $article->setTitle($form->get('title')->getData());
           $article->setContent($form->get('content')->getData());
           $article->setCreatedAt($form->get('createdAt')->getData());

           $category = $categoryRepository->findOneBy([
               'name' => 'Sport'
           ]);

           $article->addCategory($category);

           $manager->persist($article);
           $manager->flush();

           // Je fait une  redirection 
           return $this->redirectToRoute('liste_articles');
       }

       return $this->render('home/add.html.twig', [
           'form' => $form->createView()
       ]);

        
    }
}
