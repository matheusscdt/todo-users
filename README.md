# Todo Users

Este é um sistema Laravel para gerenciar tarefas e usuários. O projeto foi configurado para ser executado facilmente usando Docker e Docker Compose.

## Requisitos

- Docker
- Docker Compose

## Instalação

1. Clone o repositório:
   ```bash
   git clone <URL_DO_REPOSITORIO>
   cd todo-users
   ```

2. Configure o arquivo `.env`:
   - Copie o arquivo de exemplo `.env.example` para `.env`:
     ```bash
     cp src/.env.example src/.env
     ```
   - Atualize as variáveis de ambiente no arquivo `.env` conforme necessário.

3. Suba os containers com Docker Compose:
   ```bash
   docker-compose up -d
   ```

4. Instale as dependências do Laravel:
   ```bash
   docker exec -it todo-users-app composer install
   ```

5. Gere a chave da aplicação:
   ```bash
   docker exec -it todo-users-app php artisan key:generate
   ```

6. Execute as migrações e seeders:
   ```bash
   docker exec -it todo-users-app php artisan migrate --seed
   ```

7. Acesse o sistema:
   - O sistema estará disponível em: [http://localhost:8000](http://localhost:8000)

## Estrutura do Projeto

- **src/**: Contém o código-fonte do sistema Laravel.
- **docker-compose.yml**: Configuração do Docker Compose para o ambiente de desenvolvimento.
- **Dockerfile**: Configuração do container Docker para a aplicação Laravel.

## Testes

Para executar os testes, use o seguinte comando:
```bash
docker exec -it todo-users-app php artisan test
```

## Contribuição

1. Faça um fork do repositório.
2. Crie uma branch para sua feature ou correção de bug:
   ```bash
   git checkout -b minha-feature
   ```
3. Faça commit das suas alterações:
   ```bash
   git commit -m "Minha nova feature"
   ```
4. Envie para o repositório remoto:
   ```bash
   git push origin minha-feature
   ```
5. Abra um Pull Request.