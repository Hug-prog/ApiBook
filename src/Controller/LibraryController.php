<?php
namespace App\Controller;

use PDO;
use App\Db\ActionsBdd;
use App\Db\Cnx;
use PDOException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

   class LibraryController 
   {

      public function getLibrary($id)
      {
         return ActionsBdd::getItemById('library', $id, 'user_id');
      }

      public function getbooks($id)
      {
         try {
               $cnx = Cnx::get();
               $req = $cnx->prepare(" 
                  select * 
                  from library
                  JOIN library_book_version_requirement ON library_book_version_requirement.library_id = library.library_id
                  join book_version ON library_book_version_requirement.book_version_id = book_version.book_version_id
                  join book ON book_version.book_id = book.book_id
                  join author ON book.author_id = author.author_id 
                  where library.user_id = :id
               ");
               $req->execute([':id' => $id]);
               $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
         }
         catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }

         return $resultat;
      }

      public function getNumberBooksVersions($userId)
      {
         try {
            $cnx = Cnx::get();
            $req = $cnx->prepare("SELECT COUNT(book_version_id) FROM library_book_version_requirement WHERE library_id = :id");
            $req->execute([':id' => $userId]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
         }
         catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }
      }

      public function getNumberBooksVersionsByStatut($userId)
      {
         // try {
         //    $cnx = Cnx::get();
         //    $req = $cnx->prepare("
         //          select COUNT(book_version_id)
         //          from library
         //          JOIN library_book_version_requirement ON library_book_version_requirement.library_id = library.library_id
         //          JOIN book_version ON library_book_version_requirement.book_version_id = book_version.book_version_id
         //          JOIN contains ON book_version.book_version_id = contains.book_version
         //          JOIN statut ON book_version.statut_id = statut.statut_id
         //          where library.user_id = :id
         //    ");
         //    $req->execute([':id' => $userId]);
         //    return $req->fetchAll(PDO::FETCH_ASSOC);
         // }
         // catch (PDOException $e) {
         //       print "Erreur !: " . $e->getMessage();
         //       die();
         // }
      }

      public function addBookVersion(Request $request)
      {
         $user_id = $request->user_id;
         $book_version_id = $request->book_version_id; 
         $res = $this->getLibrary($user_id);
         try { 
            $cnx =Cnx::get();
            $req = $cnx->prepare("INSERT INTO `library_book_version_requirement` (`book_version_id`,`library_id`) VALUES ('$book_version_id','{$res[0]['library_id']}');");
            $req->execute();
         } catch (PDOException $e) {
            print($e);
            die();
         }
      }

   }