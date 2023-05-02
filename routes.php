<?php

use App\Controller\AuthController;
use App\Controller\AuthorController;
use App\Controller\BookController;
use App\Controller\BookVersionController;
use App\Controller\EditionController;
use App\Controller\LibraryController;
use App\Controller\TagController;
use App\Controller\WishListController;


$user = $_SESSION['auth'];
if(strlen($user['user_id'])>0){
   
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
   $router->get('/api/book/version/',[BookVersionController::class,'getAllBookVersion']);//ok

   // get books version by publisher 
   $router->get('/api/book/version/publisher/{id}',[BookVersionController::class,'getAllBookVersionByPublisher']);// ok



   // ***post

   // create book version
   $router->post('/api/book/version/',[BookVersionController::class,'create']);//ok





   // ***************book**********************

   // ***get

   // get all book
   $router->get('/api/book/',  [BookController::class, 'getAll']);//ok

   // get book by id
   $router->get('/api/book/{id}',[BookController::class, 'getBook']);//ok

   // get books version by author 
   $router->get('/api/book/author/{name}',[BookController::class,'getAllBookByAuthor']);

   // get books  by tag 
   $router->get('/api/book/tag/{name}',[BookController::class,'getAllBookBytags']);


   // ***post

   // create book
   $router->post('/api/book/',[BookController::class, 'create']); // ok

   // update tag 
   $router->post('/api/book/tags/update/',[BookController::class, 'updateTags']); // ok


   // *** delete
   //delete book by id
   $router->delete('/api/book/{id}',[BookController::class,'delete']);//ok∏

}



// ***************user**********************
// ***get
// get auth

// ***post
$router->post('/api/auth/login',[AuthController::class, 'login']);//ok
$router->post('/api/auth/register',[AuthController::class, 'register']);//ok
$router->post('/api/auth/logout',[AuthController::class, 'logout']);//ok

// create user
