<?php
namespace App\Controller;

use PDO;
use App\Db\Cnx;
use PDOException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;



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

   public function getAllBookVersionByAuthor($id)
   {
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare('
            SELECT book_libelle,book_description,publisher_name,edition_name
            FROM author
            INNER JOIN book  ON author.author_id = book.author_id
            INNER JOIN book_version ON book.book_id = book_version.book_id
            INNER JOIN publisher ON book_version.publisher_id =publisher.publisher_id
            INNER JOIN edition ON book_version.edition_id = edition.edition_id
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

   public function getAllBookVersionByTag($id)
   {
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare('
            SELECT book_libelle,book_description,edition_name,publisher_name
            FROM tag
            INNER JOIN book_tag ON tag.tag_id  = have.tag_id
            INNER JOIN book ON have.book_id = book.book_id
            INNER JOIN author ON book.author_id = author.author_id 
            INNER JOIN book_version  ON book.book_id = book_version.book_id
            INNER JOIN edition ON book_version.edition_id = edition.edition_id
            INNER JOIN publisher ON book_version.publisher_id =publisher.publisher_id
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

   
   public function create(Request $request)
   {
      $publisher_id = $request->publisher_id;
      $edition_id = $request->edition_id;
      $book_id = $request->book_id;
      
      try { 
         $cnx =Cnx::get();
         $req = $cnx->prepare("INSERT INTO `book_version` (`book_version_id`, `publisher_id`,`edition_id`,`book_id`) VALUES (null,'$publisher_id','$edition_id','$book_id');");
         $req->execute();
      } catch (PDOException $e) {
         print('book_version exist ');
         die();
      }

   }
}