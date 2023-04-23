<?php
namespace App\Controller;

use PDO;
use App\Db\ActionsBdd;
use App\Db\Cnx;
use PDOException;
use Illuminate\Http\JsonResponse;
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
         $res = $this->getWishList($user_id);
         try { 
            $cnx =Cnx::get();
            $req = $cnx->prepare("INSERT INTO `wishlist_book_version_requirement` (`book_version_id`,`wishlist_id`) VALUES ('$book_version_id','{$res[0]['wishlist_id']}');");
            $req->execute();
         } catch (PDOException $e) {
            print($e);
            die();
         }
      }

}