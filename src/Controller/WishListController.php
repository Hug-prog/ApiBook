<?php
namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Model\Model;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class WishListController 
{
   public function getWishList()
   {
      $user = $_SESSION['auth'];
      if($user['user_id']){
         return ActionsBdd::getItemById('wishlist', $user['user_id']);
      }
      else{
         return 'premission denied';
      }
   }

   public function addBook(Request $request)
      {
         $user = $_SESSION['auth'];
         $book_id = $request->book_id; 
         $data = ["book_id"=>new ObjectId($book_id),"user_id"=>$user["user_id"]];
         if($user['user_id']){
            $result = ActionsBdd::insertData('wishlist',$data);
            return $result->getInsertedCount() . ' documents inserted';
         }
         else{
            return 'premission denied';
         }
      }

}