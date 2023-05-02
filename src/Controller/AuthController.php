<?php 

namespace App\Controller;

use App\Actions\ActionsBdd;
use App\Actions\Cnx;
use App\Model\Model;
use Illuminate\Http\Request;


class AuthController
{

   public function getAuth($email)
   {
     return Cnx::get('users')->selectCollection('users')->findOne(['email' => $email]);     
   }


   public function login(Request $request)
   {
      $email = $request->email;
      $password = $request->password;
      $user = $this->getAuth($email);
      if(isset($user['email'])){
         if(password_verify($password, $user['password']))
         {
            $_SESSION['auth'] = [
               'authorization' => true,
               'user_id'=> $user['_id'],
               'email'=>$user['email']
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
      return Cnx::get()->selectCollection('users')->insertOne(['email'=>$email, 'password'=>$hash]);
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