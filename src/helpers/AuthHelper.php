<?php
require_once __DIR__ . '/../helpers/TokenHelper.php';

class AuthHelper {
    public static function isAuthenticated() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            return TokenHelper::validateToken($token);
        }
        return false;
    }

    public static function isAdmin() {
        $tokenData = json_decode(TokenHelper::getTokenData());

        return $tokenData && $tokenData->user_perfil === 1;
    }
}
?>
