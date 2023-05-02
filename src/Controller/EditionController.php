<?php
namespace App\Controller;

use App\Actions\Cnx;
use Illuminate\Http\Request;

class EditionController
{
   public static function create(Request $request) 
   {
      $edition_name = $request->edition_name;
      $result = Cnx::get()->selectCollection('edition')->insertOne(['edition_name'=>$edition_name]);
      return $result->getInsertedCount() . ' documents inserted';
   }
}