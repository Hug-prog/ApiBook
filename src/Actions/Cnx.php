<?php
namespace App\Actions;

use Exception;
use MongoDB\Client;

   abstract class Cnx
   {
       protected static $connection = null;
   
       /**
        * @return \MongoDB\Database
        */
       public static function get()
       {
           if (!self::$connection) {
               try {
                   self::$connection = self::createConnection();
               } catch (Exception $e) {
                   // Log db error message
                   // $e->getMessage()
                   throw new \Exception('Database ERROR');
               }
           }
   
           return self::$connection;
       }
   
       protected static function createConnection()
       {
            // start mongod process on your instance first
            $client = new \MongoDB\Client('mongodb://localhost:27017');
            
            // select a database (will be created automatically if it not exists)
            return $client->selectDatabase('book');
            
            // select a collection (will be created automatically if it not exists)
            //$coll = $db->selectCollection("mycoll");
       }
   }