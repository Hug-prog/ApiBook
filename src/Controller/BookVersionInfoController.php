<?php
namespace App\Controller;

use App\Db\ActionsBdd;
use PDO;
use App\Db\Cnx;
use PDOException;
use Illuminate\Http\Request;

class BookVersionInfoController
{
   public function getInfo($id)
   {
      $resultat = array();
      try {
         $cnx = Cnx::get();
         $req = $cnx->prepare(" 
            select note,comment,status_name
            from book_version_info 
            JOIN statut ON  book_version_info.statut_id = statut.statut_id  
            where book_version_info.book_version_id = :id
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

   public function create(Request $reques)
   {
      $statut_id = $reques->statut_id;
      $book_version_id = $reques->book_version_id;
      $note = $reques->note;
      $comment = $reques->comment;
      try { 
         $cnx =Cnx::get();
         $req = $cnx->prepare("INSERT INTO `book_version_info` (`statut_id`,`book_version_id`,`note`,` comment `) VALUES ('$statut_id','$book_version_id','$note',' $comment ');");
         $req->execute();
      } catch (PDOException $e) {
         print($e);
         die();
      }
   }

   public function update(Request $reques)
   {
      $book_version_id = $reques->book_version_id;
      $note = $reques->note;
      $comment = $reques->comment;
      $statut = $reques->statut;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `book_version_info` SET  note=$note,comment=$comment,statut=$statut WHERE book_version_id=:id ;");
         $req->execute([':id' => $book_version_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }

   public function updateNote(Request $reques)
   {
      $book_version_id = $reques->book_version_id;
      $note = $reques->note;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `book_version_info` SET  note=$note WHERE book_version_id=:id ;");
         $req->execute([':id'=>$book_version_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }
   public function updatecomment(Request $reques)
   {
      $book_version_id = $reques->book_version_id;
      $comment = $reques->comment;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `book_version_info` SET  comment=$comment WHERE book_version_id=:id ;");
         $req->execute([':id'=>$book_version_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }

   public function updateStatut(Request $reques)
   {
      $book_version_id = $reques->book_version_id;
      $statut = $reques->statut;
      try {
            
         $cnx = Cnx::get();
         $req = $cnx->prepare("UPDATE `book_version_info` SET  statut=$statut WHERE book_version_id=:id ;");
         $req->execute([':id'=>$book_version_id]);

     } catch (PDOException $e) {
          print "Erreur !: " . $e->getMessage();
         die();
     }
   }

}