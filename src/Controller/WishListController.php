<?php
namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Model\Model;
use Illuminate\Http\Request;


class WishListController
{
   public function getWishList()
   {
      $user = $_SESSION['auth'];
      if($user['user_id'] != 0){
         return ActionsBdd::getItemById('wishlist', $user['user_id'], 'user_id');
      }
      else{
         return 'premission denied';
      }
   }

   public function addBookVersion(Request $request)
      {
         $user_id = $request->user_id;
         $book_version_id = $request->book_version_id; 
         $data = [$book_version_id,$user_id];
         return ActionsBdd::insertData('wishlist',Model::getWishListBookVersionModel(),$data);
      }

}