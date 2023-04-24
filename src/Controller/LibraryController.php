<?php
namespace App\Controller;

use PDO;
use App\Actions\ActionsBdd;
use App\Actions\Cnx;
use App\Model\Model;
use PDOException;
use Illuminate\Http\Request;

   class LibraryController 
   {

      public function getbooks($id)
      {
         try {
               $cnx = Cnx::get();
               $req = $cnx->prepare(" 
                  select * 
                  from library
                  JOIN book_version ON book_version_id = library.book_version_id 
                  JOIN edition ON edition_id = book_version.edition_id
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
            $req = $cnx->prepare("SELECT COUNT(book_version_id) FROM library WHERE library.user_id = :id");
            $req->execute([':id' => $userId]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
         }
         catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }
      }

      public function getNumberBooksVersionsByStatut($user_id)
      {
         var_dump('ok');
         try {
            $cnx = Cnx::get();
            $req = $cnx->prepare("
                  SELECT 
                  COUNT(IF(library.statut_id == 1) ‘finish’,
                  COUNT(IF(library.statut_id == 2) ‘reading’,
                  COUNT(IF(library.statut_id == 3) ‘not_started’
                  FROM library
                  WHERE library.user_id = :id
            ");
            $req->execute([':id' => $user_id]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
         }
         catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }
      }

      public function addBookVersion(Request $request)
      {
         $user_id = $request->user_id;
         $book_version_id = $request->book_version_id; 
         $note = $request->note;
         $comment = $request->comment;
         $statut_id = $request->statut_id;
         $data = [$note,$comment,$user_id,$statut_id,$book_version_id];
         return ActionsBdd::insertData('library',Model::getLibraryBookVersionModel(),$data);
      }

   public function getInfoByBookVersion($id)
   {
      $resultat = array();
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare(" 
            select note,comment,status_name
            from library
            JOIN statut ON statut.statut_id = library.statut_id  
            where book_version_id = :id
         ");
         $req->execute([':id'=>$id]);
         $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
      }

      return $resultat;
   }

   public function updateInfoByBookVersion(Request $request)
   {
      $user_id = $request->user_id;
      $book_version_id = $request->book_version_id; 
      $note = $request->note;
      $comment = $request->comment;
      $statut_id = $request->statut_id;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `library` SET  note=$note,comment=$comment,statut_id=$statut_id WHERE book_version_id=:book_version__id AND user_id=:user_id;");
         $req->execute([':book_version_id' => $book_version_id,':user_id' => $user_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }

   public function updateNoteByBookVersion(Request $request)
   {
      $book_version_id = $request->book_version_id;
      $note = $request->note;
      $user_id = $request->user_id;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `library` SET  note=$note WHERE  book_version_id=:book_version__id AND user_id=:user_id;");
         $req->execute([':book_version_id' => $book_version_id,':user_id' => $user_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }

   public function updatecommentByBookVersion(Request $request)
   {
      $comment = $request->comment;
      $book_version_id = $request->book_version_id;
      $user_id = $request->user_id;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `library` SET  comment=$comment WHERE book_version_id=:book_version__id AND user_id=:user_id ;");
         $req->execute([':book_version_id' => $book_version_id,':user_id' => $user_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }

   public function updateStatutIdByBookVersion(Request $request)
   {
      $book_version_id = $request->book_version_id;
      $user_id = $request->user_id;
      $statut_id = $request->statut_id;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `library` SET  statut_id=$statut_id WHERE book_version_id=:book_version__id AND user_id=:user_id ;");
         $req->execute([':book_version_id' => $book_version_id,':user_id' => $user_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }

   }