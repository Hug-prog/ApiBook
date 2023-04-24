<?php
namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Actions\Cnx;
use App\Model\Model;
use PDOException;
use Illuminate\Http\Request;

class TagController
{
   public function create(Request $request)
   {
     $book_id = $request->book_id;
     $tag_id = $request->tag_id;
     $data = [$book_id,$tag_id];
     return ActionsBdd::insertData('book_tag',Model::getTagsModel(),$data);
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