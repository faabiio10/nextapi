<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

date_default_timezone_set('America/Sao_Paulo');

class UserDAO {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create(User $user) {

        $query = "INSERT INTO users (user_nome, user_email, user_password, user_celular, user_cpf_cnpj, user_perfil, user_token, user_token_gen, user_incdate,user_upddate,user_delete,user_deldate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            $user->user_nome,
            $user->user_email,
            MD5($user->user_password),
            $user->user_celular,
            preg_replace('/[^0-9]/is', '',$user->user_cpf_cnpj),
            $user->user_perfil,
            '',
            null,
            Date('Y-m-d H:i:s'),
            Date('Y-m-d H:i:s'),
            '',
            null
        ]);
    }

    public function read() {
        $query = "SELECT user_id, user_nome, user_email, user_celular, user_cpf_cnpj, user_perfil FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(User $user) {
        $query = "UPDATE users SET user_nome = ?, user_celular = ?, user_password = ?, user_cpf_cnpj = ?, user_perfil = ? WHERE user_email = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            $user->user_nome,
            $user->user_celular,
            $user->user_password,
            preg_replace('/[^0-9]/is', '',$user->user_cpf_cnpj),
            $user->user_perfil,
            $user->user_email,
        ]);
    }

    public function delete($user) {
        $query = "UPDATE users SET user_delete = '*', user_deldate = ? WHERE user_email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            Date('Y-m-d H:i:s'),
            $user['email']
        ]);
    }

    public function saveToken($user_id, $user_token) {
        $query = "UPDATE users SET user_token = ?, user_token_gen = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            $user_token,
            Date('Y-m-d H:i:s'),
            $user_id
        ]);
    }

    public function login($email) {
        $query = "SELECT user_id, user_nome, user_email, user_password, user_celular, user_cpf_cnpj, user_perfil, user_token,user_token_gen
                    FROM users
                    WHERE user_email = ?
                        AND user_delete != '*'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
        $query = "SELECT user_id, user_nome, user_email, user_celular, user_cpf_cnpj, user_perfil, user_token,user_token_gen
                    FROM users
                    WHERE user_email = ?
                        AND user_delete != '*'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmailCPF($email, $cpf) {
        $query = "SELECT user_id, user_nome, user_email, user_celular, user_cpf_cnpj, user_perfil, user_token,user_token_gen
                    FROM users
                    WHERE user_email = ? OR user_cpf_cnpj = ?
                        AND user_delete != '*'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email, $cpf]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validateToken($token) {
        $query = "SELECT user_id, user_nome, user_email, user_password, user_celular, user_cpf_cnpj, user_perfil, user_token,user_token_gen
                    FROM users
                    WHERE user_token = ?
                        AND TIMESTAMPDIFF(SECOND,user_token_gen,CONVERT_TZ(NOW(), '+00:00', '-03:00')) < 3600
                            AND user_delete != '*'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByToken($token) {
        $query = "SELECT user_id, user_nome, user_email, user_password, user_celular, user_cpf_cnpj, user_perfil, user_token,user_token_gen
                    FROM users
                    WHERE user_token = ?
                        AND user_delete != '*'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validaCPFCnpj($cpf_cnpj) {
        $cpf_cnpj = preg_replace('/[^0-9]/is', '',$cpf_cnpj);
        if(strlen($cpf_cnpj) == 11){
            $cpf = $cpf_cnpj;
            if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }

            for ($t = 9; $t < 11; $t++) {
                $d = 0;
                for ($c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }

            return true;
        } else if (strlen($cpf_cnpj) > 11) {
            // Garantir que seja lido sem problemas
            header("Content-Type: text/plain");

            // Capturar CNPJ
            $cnpj = $cpf_cnpj;

            // Criando Comunicação cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://brasilapi.com.br/api/cnpj/v1/" . $cnpj);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $retorno = curl_exec($ch);
            curl_close($ch);
            $cStatus   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $retorno = json_decode($retorno);

            return ($cStatus == 200 ? true : false);
        } else {
            return false;
        }

    }
}
?>
