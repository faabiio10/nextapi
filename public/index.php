<?php
    require_once 'src/controllers/AuthController.php';
    require_once 'src/controllers/UserController.php';

    require 'src/lib/vendor/autoload.php';

    $request = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
        case '/login':
            if ($method == 'POST') {
                $authController = new AuthController();
                $data = json_decode(file_get_contents('php://input'), true);
                if( (!Empty($data))) {
                    echo $authController->login($data['email'], $data['password']);
                } else {
                    http_response_code(400);
                    $data = array("message" => "Não foram encontradas informações no body da requisição!");
                    echo json_encode($data);
                }
            }
            break;

        case '/users':
            $userController = new UserController();
            if ($method == 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $userController->create($data);
            } elseif ($method == 'PUT') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $userController->update($data);
            } elseif ($method == 'DELETE') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $userController->delete($data);
            } elseif ($method == 'GET') {
                $data = json_decode(file_get_contents('php://input'), true);
                if( !Empty($data) && !Empty($data->email)) {
                    echo $userController->findByEmail($data->email);
                } else {
                    echo $userController->read();
                }
            }
            break;

        case '/user':
            $userController = new UserController();
            if ($method == 'GET') {
                $data = json_decode(file_get_contents('php://input'), true);

                if( !Empty($data) && !Empty($data['email'])) {
                    echo $userController->find($data['email']);
                } else {
                    http_response_code(400);
                    $data = array("message" => "Não foram encontradas informações no body da requisição!");
                    echo json_encode($data);
                }
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
            break;
    }
?>
