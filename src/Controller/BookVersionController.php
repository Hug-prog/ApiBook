<?php
namespace App\Controller;

use App\Actions\ActionsBdd;
use PDO;
use App\Actions\Cnx;
use App\Model\Model;
use DateTime;
use PDOException;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\VarCloner;

class BookVersionController
{
   public function getAllBookVersion()
   {
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare(" 
            select publisher_name,edition_name,book_libelle,book_description,author_first_name,author_last_name 
            from book_version
            JOIN publisher ON book_version.publisher_id = publisher.publisher_id
            join edition ON  book_version.edition_id = edition.edition_id
            join book ON book_version.book_id = book.book_id
            join author ON book.author_id = author.author_id 
         ");
         $req->execute();
         return $req->fetchAll(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
      }
   }



   public function getAllBookVersionByPublisher($id)
   {
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare('
            SELECT book_libelle,book_description,edition_name
            FROM publisher
            INNER JOIN book_version ON publisher.publisher_id  = book_version.publisher_id
            INNER JOIN edition ON book_version.edition_id = edition.edition_id
            INNER JOIN book  ON book_version.book_id = book.book_id
            INNER JOIN author ON book.author_id = author.author_id 
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

   
   public function create(Request $request)
   {
      $publisher_id = $request->publisher_id;
      $edition_id = $request->edition_id;
      $book_id = $request->book_id;
      
      $date = date('Y/m/d');

      $data = [$date,$publisher_id,$edition_id,$book_id];

      return ActionsBdd::insertData('book_version',Model::getBookVersionModel(),$data);
   }
}