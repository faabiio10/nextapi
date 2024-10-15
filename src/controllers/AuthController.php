<?php
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../helpers/TokenHelper.php';

class AuthController {
    /*
        Função de login, recebe e-mail e senha para verificação e gera JWT para autenticação das rotas
    */
    public function login($email, $password) {
        $userDAO = new UserDAO();
        $user = $userDAO->login($email);

        if ($user && MD5($password) == $user['user_password'] ) {
            $token = TokenHelper::generateToken($user['user_id'], $user['user_perfil'], $email);
            $userDAO->saveToken($user['user_id'],$token);
            return json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            return json_encode(['error' => 'Invalid credentials']);
        }
    }
}
?>
