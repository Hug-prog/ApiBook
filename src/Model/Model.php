<?php
namespace App\Model;

class Model
{
   public static function getBookModel()
   {
      return '
      `book_libelle`,
      `book_description`,
      `author_id`	
      ';
   }
}