<?php   
namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Actions\Cnx;
use Illuminate\Http\Request;

use App\Model\Model;

   class BookController 
   {
      public function getAll()
      {
        return ActionsBdd::getAll("book");
      }
      
      public function getBook($id)
      {
         return ActionsBdd::getItemById('book', $id);
      }

      public function getAllBookByAuthor($name)
      {
         return ActionsBdd::getItemByName("book", 'authors[author_first_name]',$name);
      }

      public function getAllBookBytags($name)
      {
         return ActionsBdd::getItemByName("book", 'tags[tag_name]',$name);
      }

      public function create(Request $request)
      {
         $libelle = $request->libelle;
         $description = $request->description;
         $author_first_name = $request->author_first_name;
         $author_last_name = $request->author_last_name;
         $tags= ["tag_name"=>$request->tags];
         
         $author = ["author_first_name"=>$author_first_name,"author_last_name" => $author_last_name];
         
         $data = ["libelle"=>$libelle, "description"=>$description, "authors"=>$author,"tags"=>$tags];
         $result = ActionsBdd::insertData('book', $data);
         return $result->getInsertedCount() . ' documents inserted';
      }

      public function updateTags(Request $request)
      {
         $bookId = $request->bookId;
         $tags= [$request->tags];
         $result = ActionsBdd::update("book",$bookId,['$set' => ['tags' => $tags]]);
         return 'tags updated';
      }

      public function delete($id)
      {
         $result = ActionsBdd::delete('book', $id);
         return' documents deleted'; 
      }
   }