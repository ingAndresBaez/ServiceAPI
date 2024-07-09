<?php
require '../baseDatos/config.php';
require '../baseDatos/configDB.php';
require '../auth/UserController.php';

header("Content-Type: application/json");

$database = new Database();
$db = $database->getConnection();

$userController = new UserController($db);

$method = $_SERVER['REQUEST_METHOD'];
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = str_replace('/ServiceAPI/restAPI/petition.php', '', $request);



switch ($method) {
    case 'GET':
        echo json_encode(['message' => 'Obtener Usuario']);
        break;
    case 'POST':
        if ($route === '/login') {
            $userController->loginUser();
            
        } else {
            echo json_encode(['message' => 'Insertar Datos']);
        }
        break;
    case 'PUT':
        
        break;
    case 'DELETE':
        
        break;
    default:
        echo json_encode(['error' => 'Método no admitido']);
}

