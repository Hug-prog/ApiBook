<?php   
namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Actions\Cnx;
use Illuminate\Http\Request;

use App\Model\Model;
use PDO;
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
         ];
         
         $data = [$libelle, $description, $author["author_id"]];
         return ActionsBdd::insertData('book',Model::getBookModel(),$data);
      }

   public function getAllBookByTag($id)
   {
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare('
            SELECT book_libelle,book_description,
            FROM tag
            INNER JOIN book_tag ON tag.tag_id  = have.tag_id
            INNER JOIN book ON have.book_id = book.book_id
            INNER JOIN author ON book.author_id = author.author_id 
            WHERE tag.tag_id = :id
         ');
         $req->execute([':id' =>$id]);
         return $req->fetchAll(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
      }
   }

   public function getAllBookByAuthor($id)
   {
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare('
            SELECT book_libelle,book_description
            FROM author
            INNER JOIN book  ON author.author_id = book.author_id
            WHERE author.author_id = :id
         ');
         $req->execute([':id' =>$id]);
         return $req->fetchAll(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
      }
   }

   }