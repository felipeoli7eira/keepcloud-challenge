docker compose up -d
copiar .env.example para .env
composer install


<p align="center">
    <img src="./docs/assets/hachitech.png" width="200" />
</p>

# Sobre
```shell
    ...
```

# Tecnologias
* Docker
* PHP 8.0 | Laravel 9
* Apache


* Maria DB 10.1.36

# Rodando o projeto na sua máquina
Após o download ou clone desse repositório para o seu espaço de trabalho:

```shell
make dev/local
```
Esse comando levantará os serviços MariaDB com mapeamento de portas 5001:3306 (host:container) e PHP (com Laravel) com mapeamento de portas 5000:80 (host:container)

Acessar http://localhost:5000 e ver a aplicação rodando!

Credenciais para conectar no banco de dados local:
- Usuário: ```mhblogsystem```
- Senha: ```mhblogsystem```
- Banco: ```mhblogsystem```
- Porta: ```5001```


## Comandos úteis no Makefile
Iniciar/Criar os containers da stack local
```shell
make dev/local
```

Parar todos os container da stack local
```shell
make dev/down
```
Executar as migrations no banco de dados
```shell
make dev/migrate
```

Executar as migrations no banco de dados com os seeds
```shell
make dev/migrateseed
```

Limpa todas as tabelas do banco de dados
```shell
make dev/dbwipe
```
