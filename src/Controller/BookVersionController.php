<?php
namespace App\Controller;

use App\Actions\ActionsBdd;
use PDO;
use App\Actions\Cnx;
use App\Model\Model;
use DateTime;
use PDOException;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\VarDumper\Cloner\VarCloner;

class BookVersionController
{ 
   public function getAllBookVersion()
   {
      return ActionsBdd::getAll("book_version");
   }

   // public function getAllBookVersionByAuthor($name)
   // {
   //  $res = Cnx::get()->selectCollection('book_version')->aggregate([['$lookup' => ['from' => 'book', 'localField' => 'book_id', 'foreignField' => '_id', 'as' => 'books']]]);
   //  return $res->toArray();
   // }

   public function getAllBookVersionByPublisher($name)
   {
      return ActionsBdd::getItemByName('book_version', 'publisher_name',"$name");
   }

   
   public function create(Request $request)
   {
      $publisher_name = $request->publisher_name;
      $edition_name = $request->edition_name;
      $book_id = $request->book_id;
      
      $date = date('Y/m/d');

      $data = ["date"=>$date,"publisher_name"=>$publisher_name,"edition_name"=>$edition_name,"book_id"=>new ObjectId($book_id)];

      $result = ActionsBdd::insertData('book_version', $data);
      return $result->getInsertedCount() . ' documents inserted';
   }
}