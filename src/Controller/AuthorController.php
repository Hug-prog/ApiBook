<?php
namespace App\Controller;
use App\Db\Cnx;
use App\Db\ActionsBdd;
use PDOException;

class AuthorController
{
   public static function getAuthorById($author_id)
   {
      return  ActionsBdd::getItemById('author',$author_id,'author_id');
   }

   public static function create($author)
   {
      try { 
        
         $cnx =Cnx::get();
         $req = $cnx->prepare("INSERT INTO `author` (`author_id`, `author_first_name`, `author_last_name`) VALUES (null,'{$author['author_first_name']}','{$author["author_last_name"]}');");
         $req->execute();
         return $cnx->lastInsertId();
     
     } catch (PDOException $e) {
         print('author exist ');
         die();
     }
   }


}