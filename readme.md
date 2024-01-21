## Ferramentas necessárias para subir o ambiente

- Docker
- docker-compose

## Versão das ferramentas

### Ambiente local

- Docker: 20.10.16
- docker-compose

### Dentro dos containers

- PHP: 8.0
- Mysql: 5.7
- Apache: 2.4.53 (Debian)
- Composer 2.3.7

## Como subir o ambiente

Comandos a serem executados no terminal.

### Executar o build do ambiente

`docker-compose build`

### Subindo o ambiente

`docker-compose up -d`

### Quando o ambiente subir completamente

`docker container exec php composer update`

`docker container exec php composer dump-autoload`

## Info

O projeto foi desenvolvido em formato de API, ainda não houve integração com o front-end. Portanto, validar o funcionamento do mesmo é recomendável utilizar algum client de requisição como Postman ou Insomnia.

Segue a documentação da api: https://documenter.getpostman.com/view/18939890/UzBiR9yM