<?php
class User {
    public $user_id;
    public $user_nome;
    public $user_email;
    public $user_password;
    public $user_celular;
    public $user_cpf_cnpj;
    public $user_perfil;
    public $user_token;
    public $user_token_gen;

    public function __construct($user_id, $user_nome, $user_email, $user_password, $user_celular, $user_cpf_cnpj, $user_perfil, $user_token, $user_token_gen) {
        $this->user_id          = $user_id;
        $this->user_nome        = $user_nome;
        $this->user_email       = $user_email;
        $this->user_password    = $user_password;
        $this->user_celular     = $user_celular;
        $this->user_cpf_cnpj    = $user_cpf_cnpj;
        $this->user_perfil      = $user_perfil;
        $this->user_token       = $user_token;
        $this->user_token_gen   = $user_token_gen;
    }
}
?>
