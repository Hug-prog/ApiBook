<?php 

namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Model\Model;
use Illuminate\Http\Request;


class AuthController
{

   public function getAuth($email)
   {
     return ActionsBdd::getItemById('users', $email,'email');
     
   }


   public function login(Request $request)
   {
      $email = $request->email;
      $password = $request->password;
      $user = $this->getAuth($email);
      if(isset($user)){
         if(password_verify($password, $user[0]['password']))
         {
            $_SESSION['auth'] = [
               'authorization' => true,
               'user_id'=>$user[0]['user_id'],
               'email'=>$user[0]['email']
             ];
             return $_SESSION['auth'];
         }
         else{
            return 'password failed';
         }
      }
      else
      {
         return 'acount failed';
      }
   }

   public function register(Request $request)
   {
      $email = $request->email;
      $password = $request->password;  
      $hash =  password_hash($password, PASSWORD_DEFAULT);
      $data = [$email,$hash];
      return ActionsBdd::insertData('users',Model::getUsersModel(),$data);
   }


   public function logout()
   {
      $_SESSION['auth'] = [
         'authorization' => false,
         'user_id'=>0,
         'email'=>''
       ];
       return 'logout !!';
   }

}