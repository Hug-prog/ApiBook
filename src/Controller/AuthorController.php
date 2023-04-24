<?php
namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Model\Model;

use Illuminate\Http\Request;

class AuthorController
{
   public static function getAuthorById($author_id)
   {
      return  ActionsBdd::getItemById('author',$author_id,'author_id');
   }

   public static function create(Request $request)
   {
      $author_first_name = $request->author_first_name;
      $author_last_name = $request->author_last_name ;
      $data = [$author_first_name,$author_last_name];
      return ActionsBdd::insertData('author',Model::getAuthorModel(),$data);
   }


}