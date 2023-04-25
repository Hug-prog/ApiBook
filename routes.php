<?php

use App\Controller\AuthController;
use App\Controller\AuthorController;
use App\Controller\BookController;
use App\Controller\BookVersionController;
use App\Controller\LibraryController;
use App\Controller\TagController;
use App\Controller\WishListController;
use Illuminate\Support\Facades\Auth;

$user = $_SESSION['auth'];

if($user['user_id'] != 0){
   
   // ***************library**********************
   // ***get

   // get all book in library by user
   $router->get('/api/library',[LibraryController::class,'getbooks']);  

   // get number of books versions in library
   $router->get('/api/library/book/version/number',[LibraryController::class,'getNumberBooksVersions']);

   // get number of books versions by statut in library
   $router->get('/api/library/book/version/statut/number',[LibraryController::class,'getNumberBooksVersionsByStatut']);

   // get info by book version
   $router->get('/api/library/book/version/info/{id}',[LibraryController::class,'getInfoByBookVersion']);

   // ***post

   // instert book version in library
   $router->post('/api/library/book/version/',[LibraryController::class,'addBookVersion']);

   //  ***put

   // update statut,note,comment by book version
   $router->put('/api/library/book/version/info/',[LibraryController::class,'updateInfoByBookVersion']);

   // update note in book version
   $router->put('/api/library/book/version/info/note',[LibraryController::class,'updateNoteByBookVersion']);

   // update comment in book version
   $router->put('/api/library/book/version/info/comment',[LibraryController::class,'updatecommentByBookVersion']);

   // update comment in book version
   $router->put('/api/library/book/version/info/statut',[LibraryController::class,'updateStatutIdByBookVersion']);
   ;


   // ***************wishlist**********************
   // ***get
   // get book version by user
   $router->get('/api/wishlist/',[WishListController::class,'getWishList']);

   // ***post
   // insert book version in wishlist
   $router->post('/api/wishList/book/version/',[WishListController::class,'addBookVersion']);



   // ***************book version**********************
   // ***get
   // get all books version
   $router->get('/api/book/version/',[BookVersionController::class,'getAllBookVersion']);

   // get books version by author id
   $router->get('/api/book/version/author/{id}',[BookVersionController::class,'getAllBookVersionByAuthor']);

   // get books version by publisher id
   $router->get('/api/book/version/publisher/{id}',[BookVersionController::class,'getAllBookVersionByPublisher']);

   // get books version by tag id
   $router->get('/api/book/version/tag/{id}',[BookVersionController::class,'getAllBookVersionByPublisher']);


   // ***post

   // create book version
   $router->post('/api/book/version/',[BookVersionController::class,'create']);





   // ***************book**********************

   // ***get

   // get all book
   $router->get('/api/book/',  [BookController::class, 'getAll']);

   // get book by id
   $router->get('/api/book/{id}',[BookController::class, 'getBook']);

   // ***post

   // create book
   $router->post('/api/book/',[BookController::class, 'create']);

   // *** delete
   //delete book tag
   $router->delete('/api/book/{bookId}/tag/{tagId}',[TagController::class,'delete']);


   // ***************tag**********************
   // ***get
   // ***post
   // create tag
   $router->post('/api/book/tag/',[TagController::class,'create']);

}



// ***************user**********************
// ***get
// get auth

// ***post
$router->post('/api/auth/login',[AuthController::class, 'login']);
$router->post('/api/auth/register',[AuthController::class, 'register']);
$router->post('/api/auth/logout',[AuthController::class, 'logout']);

// create user
