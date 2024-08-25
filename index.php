<?php
require_once 'vendor/autoload.php';
require "bootstrap/bootstrap.php";

// ignore the query string
// we need to handle dynamic id http://localhost:8000/room-edit/5



$uri = trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];   // ignore the query string
if ($uri == "") $uri = "/";
$routes = require_once 'routes/route.php';
/// Check if session is already started
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// auth middleware
if(!in_array($uri, ['login', 'sign-up']) && !isset($_SESSION['user_id'])) {
	header('Location: /login');
	exit;
}


$uri = trim($_SERVER['REQUEST_URI'], '/');
$uri = explode('?', $uri)[0];   // ignore the query string
if ($uri == "") $uri = "/";

// Split the URI into segments
$uriSegments = explode('/', $uri);

foreach ($routes as $route => $controllerInfo) {
    // Split the route into segments
    $routeSegments = explode('/', $route);

    // If the number of segments does not match, continue to the next route
    if (count($uriSegments) !== count($routeSegments)) {
        continue;
    }

    $params = [];

    // Compare each segment
    for ($i = 0; $i < count($uriSegments); $i++) {
		
        if (isset($routeSegments[$i][0]) && $routeSegments[$i][0] === ':') {
            // If the route segment starts with a colon, it is a parameter
            // Add it to the params array
            $params[substr($routeSegments[$i], 1)] = $uriSegments[$i];
        } elseif ($uriSegments[$i] !== $routeSegments[$i]) {
            // If the segments do not match, continue to the next route
            continue 2;
        }
    }

    // If we reach this point, it means the route matches the URI
    $controllerClass = $controllerInfo[0];
    $methodName = $controllerInfo[1];

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();
        if (method_exists($controller, $methodName)) {
            // Call the method and pass the params array
            $controller->$methodName($params);
        } else {
            echo "Method does not exist.";
        }
    } else {
        echo "Controller does not exist.";
    }

    // Stop the loop as we have found a matching route
    break;
}