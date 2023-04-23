<?php
namespace App\Db;

   class ActionsBdd
   {
      public static function getAll($table)
      {
         try {
             $cnx = Cnx::get();

             $req = $cnx->prepare("select * from $table");
             $req->execute();
             $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
         }
         catch (\PDOException $e){
            
            print "Erreur !: " . $e->getMessage();
             die();
         }
         return $resultat;  
      }

      public static function getItemById($table, $id, $id_column = 'id')
      {
        try {
            $cnx = Cnx::get();
            $req = $cnx->prepare("select * from `{$table}` where `{$id_column}` = :id");
            $req->execute([':id' => $id]);
            $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
      }

      public static function insertData($table, $alias, $data)
      {
        $symbolTabs = array_fill(0, count($data), '?');
        try {
            $cnx = Cnx::get();
            $query = "INSERT INTO `$table` ({$alias}) VALUES (";
            $query .= implode(", ", $symbolTabs);
            $query .= ")";
            $req = $cnx->prepare($query);
            $req->execute($data);
            $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
      }


   }