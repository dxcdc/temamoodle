# Guia de Troubleshooting de Ambiente Local e Docker - CDC Moodle

Este guia rápido reúne soluções práticas passo a passo para resolver problemas comuns de permissões, banco de dados, compilação de estilo e e-mails durante o desenvolvimento e suporte local/Docker do Moodle 5+.

---

## 1. Problemas de Permissão de Escrita (`moodledata`)

* **Sintoma:** O Moodle trava no instalador com uma tela branca ou exibe mensagens de erro indicando que não consegue escrever arquivos na pasta de dados.
* **Causa:** No Linux e em ambientes Docker, a pasta `moodledata` deve pertencer ao usuário do servidor web (`www-data`). Se ela for criada manualmente ou acessada por root, o Apache perde o acesso de gravação.
* **Solução:** Acesse o terminal da VPS e execute:
  ```bash
  # Mudar o dono da pasta recursivamente para o usuário do Apache
  sudo chown -R www-data:www-data /var/www/moodledata
  
  # Forçar permissões de leitura, escrita e execução
  sudo chmod -R 775 /var/www/moodledata
  ```

---

## 2. Ajuste de Charset e Collate no MariaDB

* **Sintoma:** O instalador do Moodle 5 exibe o erro crítico `unicode: must be installed and enabled` ou bloqueia o andamento da instalação com avisos de banco.
* **Causa:** O MariaDB cria bancos por padrão usando codificações legadas (latin1 ou utf8 de 3 bytes). O Moodle 5 exige estritamente a codificação `utf8mb4_unicode_ci` (UTF-8 de 4 bytes).
* **Solução:** Conecte-se ao seu terminal MariaDB e execute a query SQL de alteração:
  ```sql
  ALTER DATABASE moodle_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  ```

---

## 3. Depuração do SCSS (Compilação Silenciosa Falha)

* **Sintoma:** Você altera arquivos SCSS na pasta `scss/uena/` ou no `lib.php`, mas as alterações não aparecem na página.
* **Causa:** O compilador SCSS interno do Moodle falha silenciosamente. Se houver qualquer erro de sintaxe ou variável inexistente, o Moodle carrega o CSS do tema padrão (`boost`), fingindo que tudo está correto.
* **Solução:** Rode o script CLI abaixo no terminal da VPS para testar a compilação explícita no compilador e ver erros na tela:
  ```bash
  docker exec -it cdc-ezpoint_moodle.1.xwi10emrzeha4xhzpmm2sy759 php -r "
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

## 4. Bloqueio de Conexão SMTP com o Postal (Porta 25 vs 587)

* **Sintoma:** Moodle exibe o erro: *"Seu site não pôde se comunicar com seu servidor de e-mail."* ao enviar mensagens de teste.
* **Causa:** A porta padrão recomendada para SMTP seguro (`587`) pode estar fechada na VPS do Postal ou o serviço está escutando na porta padrão de e-mails (`25`). Adicionalmente, forçar conexão TLS em portas que usam STARTTLS causa falha instantânea no handshake.
* **Solução:** 
  1. No Moodle (**Administração do site > Servidor > E-mail > Configurações de saída**):
     * Defina o **Servidor SMTP** como: `postal.cdc.org.br:25` (Porta 25).
     * Defina a **Segurança SMTP** como: **Nenhum** (Isso inicia a conexão em texto puro e negocia a segurança *STARTTLS* de forma transparente).
  2. Garanta que o domínio do remetente (Ex: `@cdc.org.br`) esteja adicionado e validado (SPF/DKIM) na aba **Domains** do painel do Postal.
