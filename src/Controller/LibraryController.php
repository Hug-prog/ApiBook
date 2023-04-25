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

      public function getbooks()
      {
         $user = $_SESSION['auth'];
         if($user['user_id'] != 0){
            try {
               $cnx = Cnx::get();
               $req = $cnx->prepare(" SELECT * 
                  FROM library
                  INNER JOIN book_version ON book_version.book_version_id = library.book_version_id 
                  INNER JOIN edition ON edition.edition_id = book_version.edition_id
                  INNER JOIN book ON book_version.book_id = book.book_id
                  INNER JOIN author ON book.author_id = author.author_id 
                  WHERE library.user_id = :id
               ");
               $req->execute([':id' => $user['user_id']]);
               $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e) {
                  print "Erreur !: " . $e->getMessage();
                  die();
            }

            return $resultat;
         }
         else{
            return 'premission denied';
         }
        
      }

      public function getNumberBooksVersions()
      {
         $user = $_SESSION['auth'];
         if($user['user_id'] != 0){
            try {
               $cnx = Cnx::get();
               $req = $cnx->prepare("SELECT COUNT(book_version_id) FROM library WHERE library.user_id = :id");
               $req->execute([':id' => $user['user_id']]);
               return $req->fetchAll(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e) {
                  print "Erreur !: " . $e->getMessage();
                  die();
            }
         }
         else{
            return 'premission denied';
         }
        
      }

      public function getNumberBooksVersionsByStatut()
      {
         $user = $_SESSION['auth'];
         if($user['user_id'] != 0){
            try {
               $cnx = Cnx::get();
               $req = $cnx->prepare("SELECT 
                     COUNT(IF(library.statut_id = 1,1,NULL)) `finish`,
                     COUNT(IF(library.statut_id = 2,1,NULL)) `reading`,
                     COUNT(IF(library.statut_id = 3,1,NULL)) `not_started`
                     FROM library
                     WHERE library.user_id = :id
               ");
               $req->execute([':id' => $user['user_id']]);
               return $req->fetchAll(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e) {
                  print "Erreur !: " . $e->getMessage();
                  die();
            }
         }
         else{
            return 'premission denied';
         }
         
      }

      public function addBookVersion(Request $request)
      {
         $user = $_SESSION['auth'];
         if($user['user_id'] != 0){
            $book_version_id = $request->book_version_id; 
            $note = $request->note;
            $comment = $request->comment;
            $statut_id = $request->statut_id;
            $data = [$note,$comment,$user['user_id'],$statut_id,$book_version_id];
            return ActionsBdd::insertData('library',Model::getLibraryBookVersionModel(),$data);
         }
         else{
            return 'premission denied';
         }
         
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
      $user = $_SESSION['auth'];
      if($user['user_id'] != 0){
         
         $book_version_id = $request->book_version_id; 
         $note = $request->note;
         $comment = $request->comment;
         $statut_id = $request->statut_id;
         
         try {
            $cnx = Cnx::get();
            $req = $cnx->prepare("UPDATE `library` SET  note=$note,comment=$comment,statut_id=$statut_id WHERE book_version_id=:book_version__id AND user_id=:user_id;");
            $req->execute([':book_version_id' => $book_version_id,':user_id' => $user['user_id']]);

         } catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }
      }
      else{
         return 'premission denied';
      }
   }

   public function updateNoteByBookVersion(Request $request)
   {
      $user = $_SESSION['auth'];
      if($user['user_id'] != 0){
         $book_version_id = $request->book_version_id;
         $note = $request->note;
         try {
               
            $cnx = Cnx::get();
            $req = $cnx->prepare("UPDATE `library` SET  note=$note WHERE  book_version_id=:book_version__id AND user_id=:user_id;");
            $req->execute([':book_version_id' => $book_version_id,':user_id' => $user['user_id']]);

         } catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }
      }
      else{
         return 'premission denied';
      }
      
   }

   public function updatecommentByBookVersion(Request $request)
   {
      $user = $_SESSION['auth'];
      if($user['user_id'] != 0){
         $comment = $request->comment;
         $book_version_id = $request->book_version_id;
         try {
               
            $cnx = Cnx::get();
            $req = $cnx->prepare("UPDATE `library` SET  comment=$comment WHERE book_version_id=:book_version__id AND user_id=:user_id ;");
            $req->execute([':book_version_id' => $book_version_id,':user_id' =>$user['user_id']]);

         } catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }
      }
      else{
         return 'premission denied';
      }
      
   }

   public function updateStatutIdByBookVersion(Request $request)
   {
      $user = $_SESSION['auth'];
      if($user['user_id'] != 0){
         $book_version_id = $request->book_version_id;
         $statut_id = $request->statut_id;
         try {
               
            $cnx = Cnx::get();
            $req = $cnx->prepare("UPDATE `library` SET  statut_id=$statut_id WHERE book_version_id=:book_version__id AND user_id=:user_id ;");
            $req->execute([':book_version_id' => $book_version_id,':user_id' => $user['user_id']]);

         } catch (PDOException $e) {
               print "Erreur !: " . $e->getMessage();
               die();
         }
      }
      else{
         return 'premission denied';
      }
      
   }

   }