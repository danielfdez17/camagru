<?php

// Define the Controller class
class Controller
{
    // Method to load a model
    // Takes the model name as a parameter

    // This will load the model from the models directory
    // 
    // ex: Book model from Book.php
    // ------------------------------------------
    // require_once '../app/models/Book.php';
    // return new Book;
    // ------------------------------------------

    protected function loadModel($model)
    {
        // Include the model file from the models directory
        require_once '../app/models/' . $model . '.php';
        // Instantiate and return the model object
        return new $model;
    }

    // Method to render a view
    // Takes the view path, data array, and optional title as parameters
    protected function renderView($viewPath, $data = [], $title = "Book Store")
    {
        $isAuthenticated = SessionManager::isAuthenticated();
        $currentUser = SessionManager::user();
        $flashSuccess = SessionManager::flash('success');
        $flashError = SessionManager::flash('error');

        // Extract the data array into individual variables
        extract($data);
        // Include the layout file from the views directory
        require_once '../app/views/layout.php';
    }

    // Redirect unauthenticated users to login page.
    protected function requireAuth()
    {
        if (SessionManager::isAuthenticated()) {
            return true;
        }

        SessionManager::flash('error', 'Please login to continue.');
        header('Location: ' . BASE_URL . 'auth/login');
        return false;
    }
}