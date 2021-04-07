<?php

namespace App\Controller;

use App\Entity\Article;
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
     * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function vueArticle(ArticleRepository $articleRepository, $id) 
    {
        $article = $articleRepository->findByDateCreation(new \DateTime());

        $article = $articleRepository->find($id);

        return $this->render('home/vue.html.twig', [
            'article' => $article
        ]);
    }
     
    // Qui permet d'ajouter des articles
    /**
     * @Route("/article/add", name="add_article")
     */
    public function add(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $manager) 
    {
       $form = $this->createFormBuilder()
       ->add('title', TextType::class, [
           'label' => "Titre de l'article"
       ])
       ->add('content', TextareaType::class)
       ->add('createdAt', DateType::class, [
           'widget' => 'single_text',
           'input' => 'datetime'
       ])

       ->getForm();

       $form->handleRequest($request);
       // Je verifie si le form est soumis et si il est valide
       if($form->isSubmitted() && $form->isValid()){
          
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
