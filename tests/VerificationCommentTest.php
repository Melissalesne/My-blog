<?php

namespace App\Tests;

use App\Entity\Comment;
use PHPUnit\Framework\TestCase;
use App\Service\VerificationComment;

class VerificationCommentTest extends TestCase
{
    // variable comment 
    protected $comment;

    protected function setUp(): void // fonction qui hérite du parent
    {
       $this->comment = new Comment();
    }
   // Créer une fonction  
   public function testContientMotInterdit() 
   {
       $service = new VerificationComment();

    
       $this->comment->setContent("Ceci est un commentaire avec mauvais");

       $result = $service->commentaireNonAutorise($this->comment);
       $this->assertTrue($result);
   }

   public function testNeContientPasMotInterdit() 
   {
    $service = new VerificationComment();

    
    $this->comment->setContent("Ceci est un commentaire");

    $result = $service->commentaireNonAutorise($this->comment);

    $this->assertFalse($result);
   }
}
