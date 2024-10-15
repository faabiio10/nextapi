<?php

require_once __DIR__ . '/../dao/UserDAO.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenHelper {
    private static $key = "your_secret_key";

    public static function generateToken($userId, $role, $email) {
        $payload = [
            'iat' => time(),
            'exp' => time() + (60 * 60),
            'data' => [
                'userId' => $userId,
                'role' => $role
            ]
        ];

        $jwt = JWT::encode($payload, $email, 'HS256');

        return $jwt;
    }

    public static function validateToken($token) {
        try {
            $userDAO = new UserDAO();
            $aUser = $userDAO->validateToken($token);

            if( !Empty($aUser) ){
                return json_encode($aUser);
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getTokenData() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $userDAO = new UserDAO();
            $aUser = $userDAO->findByToken($token);

            if( !Empty($aUser) ){
                return json_encode($aUser);
            } else {
                return false;
            }
        }
        return false;
    }
}
?>
