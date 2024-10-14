# **Projeto API em PHP - Estrutura MVC e Autenticação JWT**

Este repositório contém uma API criada em **PHP puro** com uma estrutura MVC própria, utilizando **PDO** para a manipulação do banco de dados. A autenticação é feita por **JWT** e todas as senhas são armazenadas de forma criptografada.

---

## 🚀 **Como Iniciar o Projeto**

### Pré-requisitos:

- **Docker** instalado.

### Passo a passo:

1. Abra o terminal na pasta do projeto.
2. Execute o seguinte comando:

   ```bash
   docker compose up --build
   Ao final do processo, os contêineres (incluindo o banco de dados) estarão criados e rodando.
   ```

### 🛠️ Acesso ao Banco de Dados
```bash
Use a IDE de sua preferência (como DBeaver, MySQL Workbench, ou phpMyAdmin) para conectar-se ao banco MariaDB com as seguintes credenciais:

Usuário: admin
Senha: 123456Adm!
Banco de dados: next
Dentro da pasta tables/ do projeto, você encontrará a estrutura da tabela de usuários. Importe essa tabela para o banco para criar o usuário admin.
```
### 📄 Documentação dos Endpoints (Swagger)
Acesse o Swagger para visualizar e testar os endpoints da API:

http://localhost/swagger/

### 🔐 Autenticação e Segurança
```bash
JWT:
A autenticação das rotas é realizada via token JWT, que é criado e armazenado no banco de dados.

Validade: 60 minutos.
Após o vencimento, uma mensagem de "Não autorizado" será exibida.
Senhas criptografadas:
As senhas são salvas utilizando algoritmos de criptografia para garantir segurança e impedir acessos indevidos.
```

### 🧰 Tecnologias Utilizadas
```bash
PHP: 8.2
MariaDB: 10
Composer: para instalação da biblioteca JWT (versão 6.10)
Swagger: 4.11
```
### 📂 Estrutura do Projeto
```bash
├── tables/ # Tabelas de banco de dados (inclui a tabela de usuários)
├── public/ # Arquivos públicos acessíveis (ex: index.php)
├── src/
│ ├── config/ # Configuração do acesso ao banco de dados
│ ├── controllers/ # Controladores da API
│ ├── dao/ # DAOs para manipulação do banco
│ ├── helpers/ # Arquivos para auxilio de Autenticação e geração de token JWT
│ ├── lib/ # Arquivos para auxilio de Autenticação e geração de token JWT
│ ├── models/ # Modelos para manipulação do banco
│ ├── swagger/ # HTML de visualização do Swagger
├── docker-compose.yml # Configuração dos contêineres Docker
└── README.md # Documentação do projeto
```
