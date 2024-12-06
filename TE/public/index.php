<?php
require '../core/Router.php';
require '../app/controllers/CharlaController.php';
require '../app/controllers/LimpiezaController.php';
require '../app/controllers/PlantacionController.php';
require '../app/models/Codigos.php';

$url = $_SERVER['QUERY_STRING'];


$router = new Router();

//PLANTACION
$router->add(
    '/public/plantacion/get',
    array(
        'controller' => 'PlantacionController',
        'action' => 'getAll'
    )
);

$router->add(
    '/public/plantacion/get/{id}',
    array(
        'controller' => 'PlantacionController',
        'action' => 'getPlantacionById'
    )
);

$router->add(
    '/public/plantacion/create',
    array(
        'controller' => 'PlantacionController',
        'action' => 'createPlantacion'
    )
);

$router->add(
    '/public/plantacion/update/{id}',
    array(
        'controller' => 'PlantacionController',
        'action' => 'updatePlantacion'
    )
);

$router->add(
    '/public/plantacion/delete/{id}',
    array(
        'controller' => 'PlantacionController',
        'action' => 'deletePlantacion'
    )
);

//CHARLA
$router->add(
    '/public/charla/get',
    array(
        'controller' => 'CharlaController',
        'action' => 'getAll'
    )
);

$router->add(
    '/public/charla/get/{id}',
    array(
        'controller' => 'CharlaController',
        'action' => 'getCharlaById'
    )
);

$router->add(
    '/public/charla/create',
    array(
        'controller' => 'CharlaController',
        'action' => 'createCharla'
    )
);

$router->add(
    '/public/charla/update/{id}',
    array(
        'controller' => 'CharlaController',
        'action' => 'updateCharla'
    )
);

$router->add(
    '/public/charla/delete/{id}',
    array(
        'controller' => 'CharlaController',
        'action' => 'deleteCharla'
    )
);

//LIMPIEZA
$router->add(
    '/public/limpieza/get',
    array(
        'controller' => 'LimpiezaController',
        'action' => 'getAll'
    )
);

$router->add(
    '/public/limpieza/get/{id}',
    array(
        'controller' => 'LimpiezaController',
        'action' => 'getLimpiezaById'
    )
);

$router->add(
    '/public/limpieza/create',
    array(
        'controller' => 'LimpiezaController',
        'action' => 'createLimpieza'
    )
);

$router->add(
    '/public/limpieza/update/{id}',
    array(
        'controller' => 'LimpiezaController',
        'action' => 'updateLimpieza'
    )
);

$router->add(
    '/public/limpieza/delete/{id}',
    array(
        'controller' => 'LimpiezaController',
        'action' => 'deleteLimpieza'
    )
);



$urlParams = explode('/', $url);

$urlArray = array(
    'HTTP' => $_SERVER['REQUEST_METHOD'],
    'path' => $url,
    'controller' => '',
    'action' => '',
    'params' => ''
);

if (!empty($urlParams[2])) {
    $urlArray['controller'] = ucwords($urlParams[2]);
    if (!empty($urlParams[3])) {
        $urlArray['action'] = $urlParams[3];
        if (!empty($urlParams[4])) {
            $urlArray['params'] = $urlParams[4];
        }
    } else {
        $urlArray['action'] = 'index';
    }
} else {
    $urlArray['controller'] = 'Home';
    $urlArray['action'] = 'index';
}


if ($router->matchRoute($urlArray)) {


    $method = $_SERVER['REQUEST_METHOD'];

    $params = [];

    if ($method === 'GET') {
        $params[] = intval($urlArray['params']) ?? null;
    } elseif ($method === 'POST') {
        $json = file_get_contents('php://input');
        $params[] = json_decode($json, true);
    } elseif ($method === 'PUT') {
        $id = intval($urlArray['params']) ?? null;
        $json = file_get_contents('php://input');
        $params[] = $id;
        $params[] = json_decode($json, true);
    } elseif ($method === 'DELETE') {
        $params[] = intval($urlArray['params']) ?? null;
    }


    $controller = $router->getParams()['controller'];
    $action = $router->getParams()['action'];
    $controller = new $controller();

    if (method_exists($controller, $action)) {
        $resp = call_user_func_array([$controller, $action], $params);
    } else {
        echo "El metodo no existe";
    }
} else {
    HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la URL " . $url);
}
