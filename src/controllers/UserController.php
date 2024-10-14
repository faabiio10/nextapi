<?php
require_once 'dao/UserDAO.php';
require_once 'helpers/AuthHelper.php';

class UserController {
    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    /*
        Criação de usuário, validação de campos obrigatórios e também de usuário já existente
    */
    public function create($data) {
        if(!Empty($data['nome']) && !Empty($data['email'])  && !Empty($data['senha'])  && !Empty($data['celular'])  && !Empty($data['cpf_cnpj'])  && !Empty($data['perfil']) ){
            if (AuthHelper::isAdmin()) {

                if ( $this->userDAO->validaCPFCnpj($data['cpf_cnpj']) ) {

                    $aUser = $this->userDAO->findByEmailCPF($data['email'], $data['cpf_cnpj']);

                    if(Empty($aUser)) {
                        $user = new User(null, $data['nome'], $data['email'], $data['senha'], $data['celular'], $data['cpf_cnpj'], $data['perfil'], '', '');
                        $this->userDAO->create($user);
                        return json_encode(['message' => 'Usuário criado com sucesso!']);
                    } else {
                        http_response_code(400);
                        return json_encode(['error' => 'Usuário já cadastrado!']);
                    }
                } else {
                    http_response_code(400);
                    return json_encode(['error' => 'CPF/CNPJ Inválido!']);
                }
            } else {
                http_response_code(401);
                return json_encode(['error' => 'Unauthorized']);
            }
        } else {
            http_response_code(400);
            return json_encode(['error' => 'Campos obrigatórios não preenchidos!']);
        }
    }

    /*
        Busca de todos os usuários cadastrados
    */

    public function read() {
        if (AuthHelper::isAuthenticated()) {
            $users = $this->userDAO->read();
            return json_encode($users);
        } else {
            http_response_code(401);
            return json_encode(['error' => 'Unauthorized']);
        }
    }

    /*
        Busca de usuário específico
    */
    public function find($email) {
        if (AuthHelper::isAdmin()) {
            $user = $this->userDAO->findByEmail($email);

            if(!Empty($user)){
                return json_encode($user);
            } else {
                http_response_code(400);
                return json_encode(['message' => 'Usuário não encontrado']);
            }
        } else {
            http_response_code(401);
            return json_encode(['error' => 'Unauthorized']);
        }
    }

    /*
        Busca de usuário específico
    */
    public function update($data) {
        if (AuthHelper::isAdmin()) {
            if(!Empty($data['nome']) && !Empty($data['email'])  && !Empty($data['senha'])  && !Empty($data['celular'])  && !Empty($data['cpf_cnpj'])  && !Empty($data['perfil']) ){
                $aUser = $this->userDAO->findByEmail($data['email']);
                if( !Empty($aUser)) {
                    $cPassword = !Empty($data['senha']) ? MD5($data['senha']) : $aUser['user_password'];
                    $user = new User(null, $data['nome'], $data['email'], $cPassword, $data['celular'], $data['cpf_cnpj'], $data['perfil'], '', '');
                    $this->userDAO->update($user);
                    return json_encode(['message' => 'Usuário alterado com sucesso!']);
                } else {
                    http_response_code(404);
                    return json_encode(['error' => 'Usuário não encontrado!']);

                }
            } else {
                http_response_code(400);
                return json_encode(['error' => 'Campos obrigatórios não preenchidos!']);
            }
        } else {
            http_response_code(401);
            return json_encode(['error' => 'Unauthorized']);
        }
    }

    /*
        Exclusão de usuário por e-mail
    */

    public function delete($data) {
        if (AuthHelper::isAdmin()) {
            if(!Empty($data['email'])) {
                $aUser = $this->userDAO->findByEmail($data['email']);
                if( !Empty($aUser)) {
                    $this->userDAO->delete($data);
                    return json_encode(['message' => 'Usuário excluído com sucesso!']);
                } else {
                    http_response_code(404);
                    return json_encode(['error' => 'Usuário não encontrado!']);
                }
            } else {
                http_response_code(400);
                return json_encode(['error' => 'Campos obrigatórios não preenchidos!']);
            }
        } else {
            http_response_code(401);
            return json_encode(['error' => 'Unauthorized']);
        }
    }
}
?>
