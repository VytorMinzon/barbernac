<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


define('BASE_URL', 'http://localhost/barbernac/public/');


// Configuração do Data Base (XAMPP LOCAL)
define("DB_HOST", "localhost");
define("DB_NAME", "barbernac");
define("DB_USER", "root");
define("DB_PASS", "");

// Configuração do Email
define('HOTS_EMAIL', 'smtp.gmail.com');
define('PORT_EMAIL', '465');
define('USER_EMAIL', 'vytorminzonsenac@gmail.com');
define('PASS_EMAIL', 'lsqj zmce hdst kibv');


// Sistema de autoload das class
spl_autoload_register(function ($classe) {

    if (file_exists('../app/controllers/' . $classe . '.php')) {
        //../app/controllers/HomeController.php
        require_once '../app/controllers/' . $classe . '.php';
    }

    if (file_exists('../app/models/' . $classe . '.php')) {
        require_once '../app/models/' . $classe . '.php';
    }

    if (file_exists('../core/' . $classe . '.php')) {
        require_once '../core/' . $classe . '.php';
        //var_dump($classe);
    }
});
