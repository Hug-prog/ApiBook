<?php

use App\Controller\BookController;
use App\Controller\BookVersionInfoController;
use App\Controller\BookVersionController;
use App\Controller\LibraryController;
use App\Controller\TagController;
use App\Controller\WishListController;

// ***************library**********************
// ***get

// get library by user
$router->get('/api/library/{id}',[LibraryController::class,'getLibrary']);

// get all book in library by user
$router->get('/api/library/{id}',[LibraryController::class,'getbooks']);

// get number of books versions in library
$router->get('/api/library/book/version/number/{id}',[LibraryController::class,'getNumberBooksVersions']);

// get number of books versions by statut in library
$router->get('/api/library/book/version/statut/number/{id}',[LibraryController::class,'getNumberBooksVersionsByStatut']);


// ***post

// instert book version in library
$router->post('/api/library/book/version/',[LibraryController::class,'addBookVersion']);



// ***************wishlist**********************
// ***get
// get wishlist by user
$router->get('/api/wishlist/{id}',[WishListController::class,'getWishList']);

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

// get info by book version
$router->get('/api/book/version/info/{id}',[BookVersionInfoController::class,'getInfo']);

// ***post

// create book version
$router->post('/api/book/version/',[BookVersionController::class,'create']);

// create statut,note,comment by book version 
$router->post('/api/book/version/info/',[BookVersionInfoController::class,'create']);

//  ***put

// update statut,note,comment by book version
$router->put('/api/book/version/info/',[BookVersionInfoController::class,'update']);

// update note in book version
$router->put('/api/book/version/info/note',[BookVersionInfoController::class,'updateNote']);

// update comment in book version
$router->put('/api/book/version/info/comment',[BookVersionInfoController::class,'updatecomment']);

// update comment in book version
$router->put('/api/book/version/info/statut',[BookVersionInfoController::class,'updateStatut']);
;

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

