<?php
namespace App\Controller;
use PDO;
use App\Db\Cnx;
use PDOException;
use Illuminate\Http\Request;

class TagController
{
   public function create(Request $request)
   {
     $book_id = $request->book_id;
     $tag_id = $request->tag_id;
     try {    
      $cnx =Cnx::get();
      $req = $cnx->prepare("INSERT INTO `book_tag` (`book_id`, `tag_id`) VALUES ('$book_id','$tag_id');");
      $req->execute();
      } catch (PDOException $e) {
         print('tag exist ');
         die();
      }
   }

   public function delete($bookId,$tagId)
   {
      
      try {    
         $cnx =Cnx::get();
         $req = $cnx->prepare("DELETE FROM book_tag WHERE book_id=:book_id AND tag_id=:tag_id;");
         $req->execute([':book_id'=>$bookId,':tag_id'=>$tagId]);
         } catch (PDOException $e) {
            print($e);
            die();
      }
   }
}