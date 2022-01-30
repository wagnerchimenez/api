# Subindo o ambiente da aplicação

Dentro do diretório raiz execute o seguinte comando:

```
make environment
```

Ele irá criar a imagem necessária e subir os containers da aplicação.
Se tudo correr bem o adminer estará em execução em [Adminer](http://localhost:8080) e a api estará em execução em [api](http://localhost:8090/app/public/index.php)

# Configurando aplicação

Execute o comando ``` make container ``` para entrar no container da aplicação.

Dentro do container da aplicacao execute ``` make up ```. Ele irá baixar a dependências do projeto, gerar e executar o arquivo de migration para criar as tabelas do banco de dados e popular com dados fictícios.

**Obs: Nesse processo você precisará confirmar algumas solicitações para que possam ser executadas as migrations e o banco de dados seja populado com dados fictícios** 

![migrations](./docs/migrations.png)
![populate](./docs/populate.png)

# Adminer

![adminer login](./docs/adminer.png)

Para acessar informe os seguintes dados:
- **Servidor**: app-mysql
- **Usuário:** root
- **Senha:** root
- **Base de dados:** api




- Em seguida execute o comando:

```
make container
```
Você estará dentro do container da aplicação e para que as dependências do projeto sejam instaladas e migrations sejam executadas execute o comando:

```
make up
```