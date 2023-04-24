<?php
namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Model\Model;
use Illuminate\Http\Request;


class WishListController
{
   public function getWishList($id)
   {
      return ActionsBdd::getItemById('wishlist', $id, 'user_id');
   }

   public function addBookVersion(Request $request)
      {
         $user_id = $request->user_id;
         $book_version_id = $request->book_version_id; 
         $data = [$book_version_id,$user_id];
         return ActionsBdd::insertData('wishlist',Model::getWishListBookVersionModel(),$data);
      }

}