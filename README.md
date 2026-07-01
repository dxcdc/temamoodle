# CDC Moodle Theme (`theme_cdc_moodle`)

[![Moodle Version](https://img.shields.io/badge/Moodle-5.0%20%7C%204.4%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Compatibility](https://img.shields.io/badge/PHP-8.3%20%7C%208.2-blue.svg?style=flat-square)](https://php.net)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-lightgrey.svg?style=flat-square)](http://www.gnu.org/licenses/gpl-3.0.html)
[![Release](https://img.shields.io/badge/Release-v1.0.0--stable-green.svg?style=flat-square)](https://github.com/dxcdc/temamoodle/releases)

O **CDC Moodle Theme** é um tema filho do *theme_boost* desenvolvido sob medida para a plataforma Moodle 5+, inspirado no design moderno e sofisticado do *Uena Admin Template*. Ele combina a robustez e estabilidade do núcleo Boost com componentes de UI refinados e recursos dedicados à melhoria da experiência de aprendizagem e acessibilidade.

---

## 🌟 Funcionalidades e Diferenciais

* **Aparência Premium & Clean:** Sombras neutras otimizadas, bordas arredondadas e layouts limpos para reduzir o cansaço visual.
* **Acessibilidade Nativa (WCAG):**
  - Controle dinâmico de escala de fonte.
  - Alternador para fonte especial **OpenDyslexic**.
  - Modo escuro integrado de alto contraste.
* **Largura de Container Ajustável:** Escolha rápida entre `Wide` (tela cheia para visualização de mídias), `Boxed` (1200px para leitura confortável) e `Wide Boxed` (1500px).
* **Presets de Cores Rápidos:** Alternador de marca integrado com esquemas de cores pré-definidos (Laranja CDC, Azul Oceano, Verde Floresta).
* **Login customizado:** Tela de login totalmente personalizada com carrossel dinâmico de destaques e alinhamento responsivo para o botão de visualização de senha.

---

## 📋 Requisitos de Sistema

* **Moodle:** 4.4.x ou 5.0.x (ou superior)
* **Tema Pai:** `theme_boost` (deve estar instalado e habilitado)
* **PHP:** 8.2 ou 8.3 (compilado com suporte a `gd` e `intl`)

---

## 🚀 Instalação e Ativação

### 1. Clonar o Repositório
Acesse o diretório raiz da sua instalação Moodle e navegue até a pasta de temas:
```bash
cd /var/www/html/theme/
```

Clone este repositório criando a pasta correspondente ao componente (`cdc_moodle`):
```bash
git clone https://github.com/dxcdc/temamoodle.git cdc_moodle
```

### 2. Ativar o Tema
1. Faça login na sua plataforma Moodle como Administrador.
2. Acesse: `Administração do site > Aparência > Seletor de temas`.
3. Localize o dispositivo correspondente (Padrão/Default) e clique em **Alterar tema**.
4. Selecione o tema **CDC Moodle** e clique em **Salvar mudanças**.

---

## 🛠️ Guia do Desenvolvedor (CLI & Docker)

Caso precise realizar manutenções locais ou estender o tema dentro do ambiente de contêineres Docker da CDC:

### Compilação e Validação do SCSS
O compilador de SCSS do Moodle reverte silenciosamente para o Bootstrap padrão em caso de exceções no código compilado. Para depurar e validar seu código SCSS com exibição de erros no terminal, utilize o script CLI abaixo:

```bash
docker exec cdc-moodle php -r "
  define('CLI_SCRIPT', true); require('/var/www/html/config.php');
  \$theme = theme_config::load('cdc_moodle'); \$compiler = new core_scss();
  \$compiler->prepend_raw_scss(\$theme->get_pre_scss_code());
  \$ref = new ReflectionObject(\$theme); \$method = \$ref->getMethod('get_scss_property');
  \$method->setAccessible(true); list(\$paths, \$scss) = \$method->invoke(\$theme);
  if (is_string(\$scss)) { \$compiler->set_file(\$scss); }
  else { \$compiler->append_raw_scss(\$scss(\$theme)); \$compiler->setImportPaths(\$paths); }
  \$compiler->append_raw_scss(\$theme->get_extra_scss_code());
  try { \$compiler->to_css(); echo 'SUCCESS\n'; }
  catch (Exception \$e) { echo 'ERROR: ' . \$e->getMessage() . '\n'; }
"
```

### Limpeza de Cache de Assets
Para forçar a atualização imediata dos scripts JavaScript (AMD) e estilos CSS compilados, execute:
```bash
docker exec cdc-moodle php /var/www/html/admin/cli/purge_caches.php
```

---

---

## 🐳 Implantação Automatizada em Produção (Docker / Easypanel)

Este repositório foi projetado para permitir implantação 100% automatizada (Infrastructure as Code) usando Docker e painéis como o **Easypanel**. O Moodle é configurado dinamicamente no boot usando variáveis de ambiente.

### 1. Dockerfile Recomendado
Utilize o `Dockerfile` abaixo no seu serviço de aplicação do Easypanel. Ele compila o PHP 8.3, instala o Composer, baixa as dependências, clona o tema do GitHub e gera o `config.php` dinâmico:

```dockerfile
FROM php:8.3-apache
LABEL maintainer="CDC"

# Instalar bibliotecas essenciais e Git
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libxml2-dev libzip-dev libicu-dev \
    mariadb-client git curl unzip && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar extensões do PHP
RUN docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd intl mysqli zip soap opcache exif

# Baixar Moodle, Tema CDC e instalar dependências do Composer
RUN rm -rf /var/www/html/* \
    && git clone --depth 1 --branch MOODLE_502_STABLE https://github.com/moodle/moodle.git /var/www/html \
    && git clone --depth 1 https://github.com/dxcdc/temamoodle.git /var/www/html/theme/cdc_moodle \
    && cd /var/www/html \
    && composer install --no-dev --classmap-authoritative

# Criar config.php dinâmico baseado em variáveis de ambiente
RUN echo '<?php \n\
unset($CFG); \n\
global $CFG; \n\
$CFG = new stdClass(); \n\
$CFG->dbtype    = "mariadb"; \n\
$CFG->dblibrary = "native"; \n\
$CFG->dbhost    = getenv("MOODLE_DB_HOST") ?: "moodle-db"; \n\
$CFG->dbname    = getenv("MOODLE_DB_NAME") ?: "moodle_db"; \n\
$CFG->dbuser    = getenv("MOODLE_DB_USER") ?: "mariadb"; \n\
$CFG->dbpass    = getenv("MOODLE_DB_PASS") ?: ""; \n\
$CFG->prefix    = "mdl_"; \n\
$CFG->dboptions = array ( \n\
  "dbpersist" => 0, \n\
  "dbport" => 3306, \n\
  "dbsocket" => "", \n\
  "dbcollation" => "utf8mb4_unicode_ci", \n\
); \n\
$CFG->wwwroot   = getenv("MOODLE_WWWROOT") ?: "https://educa.cdc.org.br"; \n\
$CFG->dataroot  = "/var/www/moodledata"; \n\
$CFG->admin     = "admin"; \n\
$CFG->directorypermissions = 0777; \n\
$CFG->sslproxy  = true; \n\
$CFG->theme     = "cdc_moodle"; \n\
require_once(__DIR__ . "/lib/setup.php");' > /var/www/html/config.php

RUN chown -R www-data:www-data /var/www/html

# Configurar diretório público e expor variáveis no Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "PassEnv MOODLE_DB_HOST MOODLE_DB_NAME MOODLE_DB_USER MOODLE_DB_PASS MOODLE_WWWROOT" > /etc/apache2/conf-available/expose-env.conf \
    && a2enconf expose-env

EXPOSE 80
CMD ["apache2-foreground"]
```

### 2. Variáveis de Ambiente Necessárias (App Moodle)
Na aba **Environment** da sua aplicação no Easypanel, defina:
* `MOODLE_DB_PASS`: Senha gerada no banco de dados MariaDB.
* `MOODLE_WWWROOT`: Endereço web completo do site (ex: `https://educa.cdc.org.br`).

### 3. Regra Crítica de Volumes (Evite Sobrescrever o Código)
* **`/var/www/moodledata`**: Deve ser montado como volume persistente (necessário para armazenar uploads dos alunos).
* **`/var/www/html`**: **NÃO deve ser montado como volume!** Se montado, o Docker ignorará os deploys e ocultará o tema e as dependências do Composer.

### 4. Ajuste de Codificação do MariaDB
Ao criar o banco de dados MariaDB, execute este comando no terminal da VPS para definir a codificação UTF-8 exigida pelo Moodle 5:
```bash
docker exec -i <CONTAINER_ID_DO_BANCO> mariadb -u mariadb -p<SENHA_DO_BANCO> -e "ALTER DATABASE moodle_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

## 📄 Licença e Propriedade Intelectual

### 🔒 Direitos Reservados e Propriedade do CDC
Este tema é uma tecnologia desenvolvida e customizada sob medida para o **Centro de Desenvolvimento de Conteúdo (CDC)**. A identidade visual, os logotipos corporativos, o design de interface e os ativos de marca associados a este tema são de propriedade intelectual exclusiva do CDC. 

Qualquer reprodução, distribuição, modificação secundária ou uso deste tema por terceiros requer consentimento e autorização formal por escrito. Para solicitações de licenciamento, parcerias ou autorizações de uso, entre em contato diretamente com o CDC.

### ⚖️ Licença de Código (Moodle GPLv3)
Por ser uma extensão derivada da plataforma Moodle (software livre), a lógica do código-fonte deste plugin é distribuída em conformidade com a licença **GNU General Public License v3** (GPLv3).
