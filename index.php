<?php
error_reporting(E_NOTICE);

# include all classes and necesarry files
spl_autoload_register(function($class) {
    if (file_exists('controllers/' . $class . '.class.php')) {
        include_once('controllers/' . $class . '.class.php');
    }
    else if (file_exists('model/' . $class . '.php')) {
        include_once('model/' . $class . '.php');
    }
});

# get the applied class name from url
$url = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));

# handle the retrieved part of URL, planned to expand to bigger project
if (!empty($url[2])) {
    if (class_exists($url[2])) {
        $className = ucfirst($url[2]);
        $controller = new $className;
        
        if(isset($_POST) && !empty($_POST))
        {
            $controller->index();
        }
        else {
            $controller->showPage('home');
        }
    }
    else {
        include_once('views/error.php');
    }
}
else {
    $controller = new SimplePayment;
    $controller->showPage('home');
}
