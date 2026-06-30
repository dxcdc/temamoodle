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

## 📄 Licença e Propriedade Intelectual

### 🔒 Direitos Reservados e Propriedade do CDC
Este tema é uma tecnologia desenvolvida e customizada sob medida para o **Centro de Desenvolvimento de Conteúdo (CDC)**. A identidade visual, os logotipos corporativos, o design de interface e os ativos de marca associados a este tema são de propriedade intelectual exclusiva do CDC. 

Qualquer reprodução, distribuição, modificação secundária ou uso deste tema por terceiros requer consentimento e autorização formal por escrito. Para solicitações de licenciamento, parcerias ou autorizações de uso, entre em contato diretamente com o CDC.

### ⚖️ Licença de Código (Moodle GPLv3)
Por ser uma extensão derivada da plataforma Moodle (software livre), a lógica do código-fonte deste plugin é distribuída em conformidade com a licença **GNU General Public License v3** (GPLv3).
