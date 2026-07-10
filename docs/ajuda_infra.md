# Guia de Infraestrutura e Topologia Docker - CDC Moodle

Este documento descreve a topologia de rede, a estrutura de volumes persistentes e a parametrização do arquivo de ambiente para o Moodle 5+ e o banco de dados MariaDB rodando em contêineres Docker.

---

## 1. Topologia de Rede Isolada

Para garantir que o banco de dados da plataforma não sofra ataques cibernéticos ou tentativas de invasão externas, aplicamos um isolamento estrito de redes:

```
[ Usuário ] ----> [ HTTPS (443) / Traefik Proxy ]
                               |
                               v
                       [ Rede: web-network ]
                               |
                               v
                  [ Container: cdc-moodle-app ]
                               |
                               v
                       [ Rede: db-network ] (Sem internet/isolada)
                               |
                               v
                  [ Container: cdc-moodle-db ]
```

* **`web-network`:** Rede pública interna onde o contêiner do Moodle se comunica com o Proxy Reverso (Traefik/Nginx) para receber requisições dos usuários.
* **`db-network` (Isolada):** Rede privada criada especificamente para comunicação interna exclusiva entre o Moodle e o MariaDB. O banco de dados **não** possui exposição de portas para o host da VPS ou para a internet.

---

## 2. Docker Compose de Referência (`docker-compose.yml`)

Abaixo está a arquitetura Docker Compose padrão para staging e produção:

```yaml
version: '3.8'

services:
  # Banco de Dados MariaDB 11.4
  moodle-db:
    image: mariadb:11.4
    container_name: cdc-moodle-db
    command: --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - moodle_db_data:/var/lib/mysql
    networks:
      - db-network
    restart: always

  # Servidor Moodle (Apache + PHP 8.3)
  moodle-app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: cdc-moodle-app
    depends_on:
      - moodle-db
    environment:
      MOODLE_DB_HOST: moodle-db
      MOODLE_DB_NAME: ${DB_NAME}
      MOODLE_DB_USER: ${DB_USER}
      MOODLE_DB_PASS: ${DB_PASSWORD}
      MOODLE_WWWROOT: ${WWW_ROOT_URL}
      SSL_PROXY: "true"
    volumes:
      - moodledata_volume:/var/www/moodledata
    ports:
      - "8080:80"
    networks:
      - db-network
      - web-network
    restart: always

networks:
  db-network:
    driver: bridge
    internal: true # Bloqueia qualquer tráfego externo para esta rede
  web-network:
    driver: bridge

volumes:
  moodle_db_data:
  moodledata_volume:
```

---

## 3. Modelo de Parametrização (`.env.example`)

Para manter o repositório seguro e em conformidade com as melhores práticas de segurança de dados, crie um arquivo `.env` local copiando os placeholders do modelo abaixo. **Nunca** envie arquivos `.env` com senhas ativas para o Git!

```env
# URL de acesso ao Moodle (Sem barra no final)
# Staging: http://localhost:8080 | Produção: https://educa.cdc.org.br
WWW_ROOT_URL=https://educa.cdc.org.br

# Dados de Conexão do Banco de Dados
DB_NAME=moodle_db
DB_USER=cdc_moodle_user
DB_PASSWORD=insira_uma_senha_forte_aqui
DB_ROOT_PASSWORD=insira_a_senha_root_do_db_aqui

# Configurações do SMTP (Postal)
# Host de disparo e porta identificados em produção (Porta 25 com criptografia STARTTLS/Nenhum)
SMTP_HOST=postal.cdc.org.br:25
SMTP_USER=org/servidor/chave
SMTP_PASS=senha_da_chave_smtp
SMTP_NO_REPLY=nao-responda@cdc.org.br
```

---

## 4. Persistência de Dados e Montagem de Volumes

Para simplificar o fluxo de atualizações e builds automáticos:
* **Não monte volumes na pasta do código (`/var/www/html`):** O código do tema e da aplicação Moodle deve rodar direto da imagem construída no Dockerfile. Isso permite fazer atualizações de layout na VPS simplesmente subindo uma nova versão da imagem, sem riscos de dados antigos substituírem o código novo.
* **Volume `moodledata`:** O único diretório que deve ser montado de forma persistente é o `/var/www/moodledata`, onde o Moodle salva os dados dinâmicos enviados por alunos, imagens de cursos, certificados e arquivos de cache temporários.
