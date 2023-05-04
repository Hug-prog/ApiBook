<?php
namespace App\Controller;

use PDO;
use App\Actions\ActionsBdd;
use App\Actions\Cnx;
use App\Model\Model;
use PDOException;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

   class LibraryController 
   {

      public function getbooks()
      {
         $user = $_SESSION['auth'];
         if($user['user_id']){
            try {
               return  Cnx::get()->selectCollection('library')->aggregate(
                  [
                    [
                        '$lookup'=>[
                           "from"=> "book_version",
                           "localField"=> "book_version_id",
                           "foreignField"=> "_id",
                           "as"=> "book_version",
                        ]
                     ],
                     [
                        '$lookup'=>[
                           "from"=> "book",
                           "localField"=> "book_version.book_id",
                           "foreignField"=> "_id",
                           "as"=> "book",
                        ],
                     ]
                    
                  ]
                  )->toArray();
            }
            catch (\Exception $e) {
                  print "Erreur !: " . $e->getMessage();
                  die();
            }
         }
         else{
            return 'premission denied';
         }
        
      }

      // public function getNumberBooksVersions()
      // {
      //    $user = $_SESSION['auth'];
      //    if($user['user_id'] != 0){
      //       try {
      //          $cnx = Cnx::get();
      //          $req = $cnx->prepare("SELECT COUNT(book_version_id) FROM library WHERE library.user_id = :id");
      //          $req->execute([':id' => $user['user_id']]);
      //          return $req->fetchAll(PDO::FETCH_ASSOC);
      //       }
      //       catch (PDOException $e) {
      //             print "Erreur !: " . $e->getMessage();
      //             die();
      //       }
      //    }
      //    else{
      //       return 'premission denied';
      //    }
        
      // }

      // public function getNumberBooksVersionsByStatut()
      // {
      //    $user = $_SESSION['auth'];
      //    if($user['user_id']){
      //       $result = Cnx::get()->selectCollection("library")->find(['statut_name'=>"lu"], [
      //          'limit' => 10,
      //          'skip' => 0
      //       ])->toArray(); 
      //       //count($result)
      //       dd($result);
      //    }
      //    else{
      //       return 'premission denied';
      //    }
         
      // }

      public function addBookVersion(Request $request)
      {
         $user = $_SESSION['auth'];
         if($user['user_id']){
            $book_version_id = $request->book_version_id; 
            $note = $request->note;
            $comment = $request->comment;
            $statut_name = $request->statut_name;
            $data = ["note"=>$note,"comment"=>$comment,"user"=>$user['user_id'],"statut_name"=>$statut_name,"book_version_id"=>new ObjectId($book_version_id)];
            $result = ActionsBdd::insertData('library',$data);
            return $result->getInsertedCount() . ' documents inserted';
         }
         else{
            return 'premission denied';
         }
         
      }

   public function getInfoByBookVersion($id)
   {
      return ActionsBdd::getItemById('library',$id);
   }

   public function updateInfoByBookVersion(Request $request)
   {
      $user = $_SESSION['auth'];
      if($user['user_id'] != 0){
         $note = $request->note;
         $comment = $request->comment;
         $statut_name = $request->statut_name;
         $library_id = $request->library_id;
         $result = ActionsBdd::update("library",$library_id,['$set' => ['note' => $note,'comment' => $comment,'statut_name' => $statut_name]]);
         return $result->getModifiedCount(). ' statut updated';
         
      }
      else{
         return 'premission denied';
      }
   }

   public function updateNoteByBookVersion(Request $request)
   {
      $user = $_SESSION['auth'];
      if($user['user_id'] != 0){
         $note = $request->note;
         $library_id = $request->library_id;
         $result = ActionsBdd::update("library",$library_id,['$set' => ['note' => $note]]);
         return $result->getModifiedCount(). ' statut updated';
        
      }
      else{
         return 'premission denied';
      }
      
   }

   public function updatecommentByBookVersion(Request $request)
   {
      $user = $_SESSION['auth'];
      if($user['user_id']){
         $comment = $request->comment;
         $library_id = $request->library_id;
         $result = ActionsBdd::update("library",$library_id,['$set' => ['comment' => $comment]]);
         return $result->getModifiedCount(). ' statut updated';
      }
      else{
         return 'premission denied';
      }
      
   }

   public function updateStatutIdByBookVersion(Request $request)
   {
      $user = $_SESSION['auth'];
      if($user['user_id']){
         $library_id = $request->library_id;
         $statut_name = $request->statut_name;
         $result = ActionsBdd::update("library",$library_id,['$set' => ['statut_name' => $statut_name]]);
         return $result->getModifiedCount(). ' statut updated';     
      }
      else{
         return 'premission denied';
      }
      
   }

   }