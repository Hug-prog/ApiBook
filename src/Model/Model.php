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
   public static function getAuthorModel()
   {
      return '
      `author_id`,
       `author_first_name`,
        `author_last_name`
      ';
   }
   public static function getBookVersionModel()
   {
      return ' 
      `release_year`,
      `publisher_id`,
      `edition_id`,
      `book_id`
      ';
   }
   public static function getLibraryBookVersionModel()
   {
      return '
      `note`,
      ` comment `,
      `user_id`,
      `statut_id`,
      `book_version_id`
      ';
   }
   public static function getTagsModel()
   {
      return '
      `book_id`, 
      `tag_id
      ';
   }
   public static function getWishListBookVersionModel()
   {
      return '
      `book_version_id`,
      `user_id`
      ';
   }
}