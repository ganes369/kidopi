# Projeto PHP KIDOPI

Este é um projeto PHP que utiliza XAMPP como ambiente de desenvolvimento local e o pacote vlucas/dotenv para recuperar variáveis de ambiente do banco de dados.

## Requisitos

- PHP
- XAMPP (ou outro servidor local)
- Composer
- Banco de dados (por exemplo, MySQL)

## Configuração

1. Clone este repositório para o diretório do seu servidor local (por exemplo, `htdocs` para XAMPP).
2. Navegue até o diretório do projeto no terminal.
3. Execute o comando `composer install` para instalar as dependências, incluindo o pacote vlucas/dotenv.
4. Renomeie o arquivo `.env.example` para `.env`.
5. No arquivo `.env`, configure as variáveis de ambiente do banco de dados de acordo com as configurações do seu ambiente local:

   ```dotenv
   URL_DB='mysql:host=localhost;dbname=kidope'
   USER_DB=root
   PASS_DB=''


   URL=https://dev.kidopilabs.com.br/exercicio/covid.php?pais='
   ```

   Certifique-se de substituir `nome_do_banco_de_dados`, `usuario_do_banco` e `senha_do_banco` pelos valores corretos do seu ambiente.

## Rodando o Script do Banco de Dados

1. Certifique-se de que o servidor do banco de dados esteja em execução (por exemplo, MySQL no XAMPP).
2. No terminal, navegue até o diretório do projeto.
3. Execute o seguinte comando para importar o script do banco de dados Dump.sql:

   ```bash
   mysql -u usuario_do_banco -p nome_do_banco_de_dados < Dump.sql
   ```

   Substitua `usuario_do_banco` pelo nome de usuário do seu banco de dados e `nome_do_banco_de_dados` pelo nome do banco de dados que você configurou no arquivo `.env`.

## Uso

http://localhost/kidopi-test/ substitua kidopi-test pelo seu caminho
