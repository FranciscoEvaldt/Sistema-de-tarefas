# Sistema de Tarefas

## Descrição Geral
Este projeto é um sistema web de controle de tarefas pessoais, desenvolvido com PHP 8, MySQL, Bootstrap 5 e jQuery.  
O usuário pode fazer:

- Cadastre-se, fazer login e logout.
- Criar, editar e excluir tarefas.
- Marcar tarefas como concluídas.
- Filtrar tarefas por status (pendentes/concluídas).

## Passo a passo para rodar localmente

### 1. Requisitos
- Laragon ou outro servidor local (PHP + MySQL)

### 2. Configuração do projeto 
1. Coloque o projeto na pasta 'www' do Laragon
2. O projeto estara disponibilizado ja estruturado

### 3. Configuração do banco de dados
1. Abra o Laragon e clique em Start All (Apache + MySQL).  
2. Acesse o phpMyAdmin: http://localhost/phpmyadmin
3. Crie um banco de dados, ex: `teste_webbrain`.  
4. Importe o arquivo `database/estrutura.sql` para criar as tabelas.  
5. No arquivo `config/db.php`, configure a conexão:
$DB_HOST = '127.0.0.1';
$DB_NAME = 'teste_webbrain';
$DB_USER = 'root';
$DB_PASS = '';
6. Ajuste $DB_USER e $DB_PASS caso seu MySQL tenha usuário ou senha diferente.

### 4. Acessando o sistema
- Abra o navegador e acesse: http://localhost/teste_webbrain/public/

## Estrutura do codigo
sistema-tarefas/
  public/              ← Arquivos acessíveis pelo navegador
    index.php         ← Tela de login
    dashboard.php     ← Tela principal com lista de tarefas
    register.php      ← Tela de cadastro de usuário
    assets/           ← CSS e JS 
  config/
    db.php            ← Conexão com o banco de dados
  database/
    estrutura.sql     ← Script para criar tabelas e dados iniciais
   docs/
     README.md         ← Documentação do projeto
