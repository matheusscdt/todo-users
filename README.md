# Todo Users

Este é um sistema Laravel para gerenciar tarefas e usuários. O projeto foi configurado para ser executado facilmente usando Docker e Docker Compose.

## Requisitos

- Docker
- Docker Compose

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/matheusscdt/todo-users.git
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

## Importante: Configuração da Chave de Criptografia

Após gerar a chave do projeto com o comando:

```bash
php artisan key:generate
```

Certifique-se de atualizar a chave gerada no arquivo `.env.testing` e no arquivo `phpunit.xml` para garantir que os testes utilizem a mesma chave de criptografia. Isso é essencial para evitar erros relacionados à criptografia durante a execução dos testes.

## Estrutura do Projeto

- **src/**: Contém o código-fonte do sistema Laravel.
- **docker-compose.yml**: Configuração do Docker Compose para o ambiente de desenvolvimento.
- **Dockerfile**: Configuração do container Docker para a aplicação Laravel.

## Rotas da Documentação

O projeto inclui duas rotas para acessar a documentação da API:

1. **Documentação em JSON**:
   - URL: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)
   - Descrição: Retorna o arquivo `api.json` gerado pelo Scramble, contendo a especificação OpenAPI da API.

2. **Interface Interativa**:
   - URL: [http://localhost:8000/api/docs](http://localhost:8000/api/docs)
   - Descrição: Exibe a documentação da API em uma interface interativa utilizando o Stoplight Elements.

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