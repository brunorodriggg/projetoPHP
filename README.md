## Tema escolhido 
- Gerenciador de Tarefas.

## Funcionalidades
- Cadastro de usuário com verificação de duplicidade
- Login com verificação de senha criptografada
- Sessão de usuário com proteção de páginas restritas
- CRUD de itens (criar, listar, editar, excluir)
- Interface moderna com Bootstrap
- Segurança com prepared statements e password_hash()

## Requisitos
- PHP 7.4 ou superior
- MySQL ou MariaDB
- XAMPP, Laragon ou outro servidor local com Apache + MySQL

## Como instalar e rodar
- Copie a pasta projeto_php para htdocs (caso esteja usando XAMPP).
- Inicie o Apache e o MySQL pelo painel do XAMPP.
- Acesse: http://localhost/phpmyadmin
- Crie um banco de dados com o nome: projeto_php
- Importe o arquivo sql/criar_banco.sql.
- No navegador, acesse o sistema: http://localhost/projeto_php/

## Usuário de teste (opcional)
- Login: leo
- Senha: 123456

## Segurança aplicada
Uso de prepared statements em todas as consultas ao banco
Criptografia de senhas com password_hash() e password_verify()
Validações no backend para evitar falhas
Páginas protegidas com session_start() e verificação de sessão
Escapando campos com htmlspecialchars para evitar XSS

## Autor
- Bruno Rodrigo Reis do Rosario;
