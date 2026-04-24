# Catalogo de Produtos

Projeto simples de catalogo de produtos, feito com PHP e HTML5.

## Requisitos

- PHP 8+ (com extensao PDO MySQL habilitada)
- MySQL 8+ (ou MariaDB compativel)
- Servidor local:
  - PHP embutido (`php -S`), ou
  - XAMPP/WAMP/Laragon (Apache + MySQL)

## Instalacao

### 1) Clone o projeto

```bash
git clone <url-do-repositorio>
cd "catalogo de produtos"
```

### 2) Crie o banco e importe o SQL

O arquivo `catalogo_de_produtos.sql` ja contem:
- criacao do banco `catalogo_produtos`
- criacao das tabelas (`produtos`, `imagens`, `usuarios`)

Importe esse arquivo no seu MySQL:

- via terminal:

```bash
mysql -u root -p < catalogo_de_produtos.sql
```

- ou via ferramenta grafica (phpMyAdmin, HeidiSQL, MySQL Workbench), executando o script inteiro.

### 3) Configure a conexao com o banco

Edite o arquivo `config/database.php` com os dados do seu ambiente:

- `host`
- `db`
- `user`
- `pass`
- `port`

Exemplo:

```php
$host = 'localhost';
$db   = 'catalogo_produtos';
$user = 'root';
$pass = 'sua_senha';
$port = 3306;
```

## Como rodar

### Opcao A: servidor embutido do PHP

Na raiz do projeto:

```bash
php -S localhost:8000
```

Abra no navegador:

- [http://localhost:8000](http://localhost:8000)

### Opcao B: XAMPP (ou similar)

1. Coloque o projeto dentro da pasta web do Apache (ex.: `htdocs` no XAMPP)
2. Inicie Apache e MySQL
3. Acesse pelo navegador (ajuste o caminho conforme a pasta):
   - `http://localhost/catalogo de produtos/`

## Estrutura basica

- `index.php`: entrada publica
- `admin.php`: area administrativa
- `app/`: logica das paginas
- `models/`: acesso a dados
- `views/`: templates HTML/PHP
- `config/database.php`: conexao com o banco

## Observacoes

- O projeto usa upload de imagens em `uploads/`.
- Garanta permissao de escrita nessa pasta no seu ambiente local.
