# Projeto SENAI — Sistema de Gerenciamento

Sistema web desenvolvido em PHP com MySQL para gerenciamento de produtos, clientes e usuários.

## Requisitos

- XAMPP (ou qualquer servidor com Apache + PHP + MySQL)
- PHP 8.0 ou superior
- Navegador moderno

## Instalação

1. Clone o repositório dentro da pasta `htdocs` do XAMPP
2. Importe o arquivo `banco.sql` no phpMyAdmin para criar o banco de dados
3. Inicie o Apache e o MySQL pelo painel do XAMPP
4. Acesse `http://localhost/aula2` no navegador

## Login padrão

- Email: `admin@email.com`
- Senha: `123456`

## Funcionalidades

- Login com autenticação por sessão
- Cadastro, edição e exclusão de produtos
- Cadastro, edição e exclusão de clientes
- Cadastro de usuários
- Upload de imagens com exclusão automática ao deletar registros

## Estrutura de arquivos

```
aula2/
├── banco.sql               — Script de criação do banco de dados
├── conexao.php             — Configuração da conexão com o banco
├── login.php               — Tela de login
├── logout.php              — Encerra a sessão
├── cadastro_produtos.php   — Gerenciamento de produtos
├── cadastro_cliente.php    — Gerenciamento de clientes
├── cadastro_usuario.php    — Gerenciamento de usuários
├── delete.php              — Exclusão de registros e imagens
├── css/
│   └── style.css           — Estilos personalizados
└── uploads/                — Imagens enviadas pelo sistema
```

## Tecnologias

- PHP
- MySQL
- Tailwind CSS
