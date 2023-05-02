<?php
namespace App\Actions;

   class ActionsBdd
   {
      public static function getAll($table)
      {
         try {
             return  Cnx::get()->selectCollection($table)->find([], [
                'limit' => 10,
                'skip' => 0
             ])->toArray(); 
         }
         catch (\Exception $e){
            
            print "Erreur !: " . $e->getMessage();
             die();
         } 
      }

      public static function getItemById($table, $id)
      {
        try {
            
            return  Cnx::get()->selectCollection($table)->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]); 


        }
        catch (\Exception $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
      }

      public static function insertData($table,$data)
      {

        try {
            return Cnx::get()->selectCollection($table)->insertOne($data);
        }
        catch (\Exception $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
      }

      public static function delete($table,$id)
      {
        try {
            return Cnx::get()->selectCollection($table)->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        }
        catch (\Exception $e) {
            print "Erreur!: ". $e->getMessage();
            die();
        }
      }

      public static function update($table,$id,$data)
      {
        try {
            return Cnx::get()->selectCollection($table)->updateOne(['_id' => new \MongoDB\BSON\ObjectId($id)],$data);
        }
        catch (\Exception $e) {
            print "Erreur!: ". $e->getMessage();
            die();
        }               
      }
   }