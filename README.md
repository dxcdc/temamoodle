# CDC Moodle Theme (`theme_cdc_moodle`)

Este é o tema oficial customizado e otimizado para a plataforma Moodle 5+, baseado no design moderno e premium do Uena Admin Template. O tema foi desenvolvido como um tema filho do **Boost** (tema padrão do Moodle), mantendo total compatibilidade com todas as funções nativas e adicionando recursos avançados de customização e acessibilidade.

---

## ✨ Principais Recursos

- **Aparência Premium:** Sombras neutras escuras, bordas suaves de cartões e tipografia otimizada.
- **Modo Escuro Nativo:** Suporte completo para modo escuro com detecção automática e controle manual.
- **Presets de Cores Rápidos:** Alternador de esquemas de cores pré-configurados (Laranja CDC, Azul Oceano, Verde Floresta).
- **Largura de Container Customizável:** Seleção de layout entre `Wide` (Tela Cheia), `Boxed` (1200px) e `Wide Boxed` (1500px).
- **Painel de Acessibilidade:** Ajuste fino de tamanho de fonte, fontes especiais para dislexia e alto contraste.
- **Página de Login Customizada:** Layout moderno com campos alinhados de forma consistente, suporte a carrossel de imagens e fundo personalizado.

---

## 🛠️ Como Instalar no Moodle

Para instalar este tema no seu servidor Moodle:

1. Acesse o terminal do seu servidor Moodle e navegue até a pasta de temas:
   ```bash
   cd /caminho-do-moodle/theme/
   ```
2. Clone este repositório criando a pasta `cdc_moodle`:
   ```bash
   git clone https://github.com/dxcdc/temamoodle.git cdc_moodle
   ```
3. Acesse o painel de administração do Moodle (`Administração do site > Aparência > Seletor de temas`) e ative o tema **CDC Moodle**.

---

## 💻 Desenvolvimento e Depuração

Se você precisar depurar ou atualizar o código SCSS/CSS do tema no ambiente Docker:

### 1. Testar Compilação do SCSS
O compilador de SCSS do Moodle falha silenciosamente em caso de erros de sintaxe. Para forçar a exibição dos erros reais de compilação, execute o seguinte comando:
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

### 2. Limpar Caches do Moodle
Após qualquer modificação nos arquivos do tema, limpe os caches para forçar a atualização dos assets minificados:
```bash
docker exec cdc-moodle php /var/www/html/admin/cli/purge_caches.php
```
