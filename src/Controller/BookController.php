<?php   
namespace App\Controller;

use App\Db\ActionsBdd;
use Illuminate\Http\Request;

use PDO;
use App\Db\Cnx;
use App\Model\Model;
use Illuminate\Container\BoundMethod;
use PDOException;

   class BookController 
   {
      public function getAll()
      {
        return (ActionsBdd::getAll('book'));
      }
      
      public function getBook($id)
      {
         return ActionsBdd::getItemById('book', $id, 'book_id');
      }

      public function create(Request $request)
      {
         $libelle = $request->libelle;
         $description = $request->description;
         $author = [
            "author_id" => $request->author_id,
            "author_first_name" =>  $request->author_first_name,
            "author_last_name" => $request->author_last_name,
         ];

         if($author['author_id'] == "null" )
         {
            $author['author_id'] = AuthorController::create($author);
         }
         else
         {
            $author['author_id'] = AuthorController::getAuthorById($author);
         }
         // $data = "'$libelle','$description',{$author["author_id"]}";
         $data = [$libelle, $description, $author["author_id"]];

         return ActionsBdd::insertData('book',Model::getBookModel(),$data);

      }

   }