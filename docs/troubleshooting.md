# Guia de Troubleshooting e Lições Aprendidas - CDC Moodle

Este documento detalha os principais desafios técnicos enfrentados durante o desenvolvimento do tema **CDC Moodle** (baseado no Uena), bem como as soluções aplicadas e os procedimentos de depuração em produção.

---

## 1. Compilação Silenciosa do SCSS (Crítico)
* **O Problema:** O compilador SCSS interno do Moodle falha silenciosamente. Se houver qualquer erro de sintaxe, variável indefinida ou mixin inválido, o Moodle intercepta a exceção e carrega o arquivo Bootstrap padrão (`boost`). Nunca presuma que o SCSS compilou com sucesso apenas porque a página carregou sem erro.
* **A Solução:** Sempre que fizer alterações de estilo no SCSS, rode o script CLI abaixo no terminal da VPS para testar a compilação explícita no compilador e ver erros na tela:
  ```bash
  docker exec -it $(docker ps -qf name=moodle | head -n1) php -r "
    define('CLI_SCRIPT', true);
    require('/var/www/html/config.php');
    \$theme = theme_config::load('cdc_moodle');
    \$compiler = new core_scss();
    \$compiler->prepend_raw_scss(\$theme->get_pre_scss_code());
    \$ref = new ReflectionObject(\$theme);
    \$method = \$ref->getMethod('get_scss_property');
    \$method->setAccessible(true);
    list(\$paths, \$scss) = \$method->invoke(\$theme);
    if (is_string(\$scss)) {
        \$compiler->set_file(\$scss);
    } else {
        \$compiler->append_raw_scss(\$scss(\$theme));
        \$compiler->setImportPaths(\$paths);
    }
    \$compiler->append_raw_scss(\$theme->get_extra_scss_code());
    try {
        \$compiled = \$compiler->to_css();
        echo 'SUCCESS\n';
    } catch (Exception \$e) {
        echo 'ERROR: ' . \$e->getMessage() . '\n';
    }
  "
  ```

---

## 2. Redirecionamento de Proxy Reverso (Reverse Proxy / SSL)
* **O Problema:** Quando o Moodle está atrás de um proxy reverso SSL (como o Traefik do Easypanel), o proxy lida com a conexão HTTPS externa e repassa o tráfego internamente via HTTP. Isso causa loops de redirecionamento ou bloqueio de CSS/JS (Mixed Content).
* **A Solução:** É obrigatório definir a configuração de proxy SSL no arquivo `config.php` da instalação:
  ```php
  $CFG->sslproxy = true;
  ```

---

## 3. Alinhamento do Ícone de Olho (Ocultar/Mostrar Senha)
* **O Problema:** No formulário de login, os campos de entrada e botões são dispostos lado a lado. O script AMD nativo do Moodle (`core/togglesensitive`) injeta dinamicamente o botão de olho após o input de senha. Por padrão, o Bootstrap 5 permite quebra de linha (`flex-wrap: wrap`) no grupo de inputs, o que joga o ícone de olho para a linha inferior.
* **A Solução:** Forçar o contêiner `.toggle-sensitive-wrapper` a não quebrar as linhas:
  ```css
  .toggle-sensitive-wrapper {
      display: flex !important;
      flex-wrap: nowrap !important;
      width: 100% !important;
  }
  ```

---

## 4. Presets e Gerenciamento do LocalStorage
* **O Problema:** Ao introduzir novas variáveis ou chaves de controle (ex: `layoutContainer`, `themeBg`) no painel de acessibilidade do tema, os navegadores dos usuários que já visitaram o Moodle carregarão um objeto JSON desatualizado do `localStorage` (sem essas chaves).
* **A Solução:** **Nunca** atribua o resultado do `JSON.parse(saved)` diretamente ao seu objeto `settings`. Faça sempre uma mescla (`$.extend`) com os valores padrão para assegurar que propriedades novas não fiquem como `undefined`:
  ```javascript
  var saved = localStorage.getItem('uena_accessibility_settings');
  if (saved) {
      try {
          var loaded = JSON.parse(saved);
          settings = $.extend({}, settings, loaded);
      } catch (e) {
          // Ignorar erros
      }
  }
  ```

---

## 5. Redimensionamento e Centralização de Layout
* **O Problema:** Não tente aplicar `max-width` ou regras de centralização diretamente no elemento `#page.drawers`. O Moodle calcula as margens esquerdas e direitas das gavetas laterais dinamicamente via JS com base nas dimensões deste elemento, o que causa bugs de posicionamento.
* **A Solução:** Direcione as regras de centralização e largura máxima para a classe interna `.main-inner` (ou contêiner `#topofscroll`), que envolve apenas o cabeçalho e a área de conteúdo:
  ```css
  #page.drawers .main-inner,
  .main-inner {
      max-width: var(--theme-container-width, 100%) !important;
      margin-left: auto !important;
      margin-right: auto !important;
      width: 100% !important;
      transition: max-width 0.22s ease-in-out !important;
  }
  ```

---

## 6. Ajuste de Estilos de Avatar e Iniciais do Menu de Usuário
* **O Problema:** O botão do menu do usuário (`#user-menu-toggle`) herda propriedades nativas de botões. É imperativo remover a seta do dropdown (`::after { display: none !important }`) e resets de borda/foco para manter o avatar limpo.
* **A Solução:** Estilize as iniciais (`.userinitials`) com cores da marca CDC (laranja translúcido no fundo e texto em laranja escuro) para evitar que o visual cinza padrão quebre a estética moderna:
  ```css
  .usermenu .avatar span.userinitials {
      background-color: rgba(255, 114, 13, 0.1) !important;
      color: #FF720D !important;
      font-weight: 600 !important;
      border-radius: 50% !important;
  }
  ```
