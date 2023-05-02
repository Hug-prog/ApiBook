<?php

use App\Actions\Cnx;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

session_start();

if(!isset($_SESSION['auth'])){
  $_SESSION['auth'] = [
    'authorization' => false,
    'user_id'=>0,
    'email'=>''
  ];
}


include 'config.php';
// Dispatch the request through the router
try {
  $response = $router->dispatch($request);

  // Send the response back to the browser
  $jsonResponse= new JsonResponse($response);
  $jsonResponse->send();
} 
catch(NotFoundHttpException $e) {

  http_response_code(404);

}
catch(\Exception $e) {
  
  echo json_encode([
    'error' => $e->getMessage(),
    'code'  => $e->getCode(),
  ]);
  
}

//dd($_SESSION['auth']);