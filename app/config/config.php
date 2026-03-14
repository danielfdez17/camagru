<?php

define('DB_DRIVER', getenv('DB_DRIVER') ?: 'mysql');
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'user');
define('DB_PASS', getenv('DB_PASS') ?: 'password');
define('DB_NAME', getenv('DB_NAME') ?: 'bookDB');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/book-store/public/');

?>