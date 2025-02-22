
## Como Rodar o Projeto

### Pré-requisitos

- PHP 7.0 ou superior.
- MySQL ou MariaDB.
- Apache ou servidor web similar.
- PHPMyAdmin (opcional, para gerenciar o banco de dados).

### Passo a Passo



1. **Configure o banco de dados**:
    - No arquivo `DefineCredenciais.php`, altere as credenciais para o seu banco de dados MySQL.
    - Crie um banco de dados chamado `entrevista` (ou altere o nome no arquivo `DefineCredenciais.php` para o nome desejado).
    - Importe o esquema de banco de dados utilizando o arquivo SQL (caso tenha criado um). Caso contrário, você pode criar uma tabela `usuarios` manualmente com as colunas:
      - `id` (INT, auto-increment)
      - `nome` (VARCHAR)
      - `cpf` (VARCHAR)
      - `data_cadastro` (DATETIME)

2. **Suba o projeto para o servidor**:
    - Se você estiver utilizando o **Apache** no seu ambiente local, mova os arquivos para o diretório `htdocs` ou qualquer outro diretório configurado no seu servidor web.
    - Se estiver usando PHP, basta acessar a URL do seu servidor local (geralmente `http://localhost/`).





## Autor

Bruno De Lima - (https://github.com/BrunoCopeiro)

