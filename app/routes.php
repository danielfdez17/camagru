<?php

// Define an array of routes for the application
$routes = [
    // Route for the home page, maps to the 'index' method of 'BookController'
    '' => ['controller' => 'BookController', 'method' => 'index'],

    // Route for the books list page, maps to the 'index' method of 'BookController'
    'books' => ['controller' => 'BookController', 'method' => 'index'],

    // Route for a specific book page, maps to the 'bookId' method of 'BookController'
    'book/id' => ['controller' => 'BookController', 'method' => 'bookById'],

    // Route for adding a new book, maps to the 'addBook' method of 'BookController'
    'book/add' => ['controller' => 'BookController', 'method' => 'addNewBook'],

    // Route for deleting a book, maps to the 'delete' method of 'BookController'
    'book/delete' => ['controller' => 'BookController', 'method' => 'deleteBook'],

    // Route for updating a book, maps to the 'update' method of 'BookController'
    'book/update' => ['controller' => 'BookController', 'method' => 'updateBook'],

    // Route for the login page, maps to the 'login' method of 'AuthController'
    'auth/login' => ['controller' => 'AuthController', 'method' => 'login'],

    // Route for the registration page
    'auth/register' => ['controller' => 'AuthController', 'method' => 'register'],

    // Route for logging out current user
    'auth/logout' => ['controller' => 'AuthController', 'method' => 'logout'],

    // Route for viewing/updating current profile
    'auth/profile' => ['controller' => 'AuthController', 'method' => 'profile'],
];

?>