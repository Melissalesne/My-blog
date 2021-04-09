<?php 
namespace App\Service;

use App\Entity\Comment;


class VerificationComment 
{
    // Fonction + passer en paramètre l'objet Comment
    public function commentaireNonAutorise(Comment $comment) 
    {
        // Vérifie si le commentaire contient des mots interdit
        $nonAutorise = [
            "mauvais",
            "merde"

        ];
        // Bouclé sur les noms non autorisées
        foreach($nonAutorise as $word){
           //Fonction strpos: Une chaîne de caractère ce trouve dans une autre chaîne de caractère
        if(strpos($comment->getContent(), $word)){
            // Si sa retourne true, le commentaire n'est pas autorisé
            return true;
        }
          } 
          // Si il retourne false le commentaire sera autorisé
       return false;
    }
}