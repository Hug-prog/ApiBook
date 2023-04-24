<?php   
namespace App\Controller;

use App\Actions\ActionsBdd;
use Illuminate\Http\Request;

use App\Model\Model;

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
         ];
         
         $data = [$libelle, $description, $author["author_id"]];
         return ActionsBdd::insertData('book',Model::getBookModel(),$data);
      }

   }