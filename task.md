# Tarefas de Desenvolvimento: Tema Uena Moodle

- `[x]` 1. Fundação do Tema Moodle
  - `[x]` Criar estrutura local de diretórios (`theme/uena_moodle`).
  - `[x]` Criar `version.php`.
  - `[x]` Criar `config.php` (herança do Boost).
  - `[x]` Criar `lang/en/theme_uena_moodle.php` (idioma).
  - `[x]` Criar `lib.php` (funções e hooks).
  - `[x]` Copiar pasta do tema para dentro do container Docker (`docker cp`).
  - `[x]` Instalar o tema no banco de dados Moodle via CLI e ativá-lo.
- `[x]` 2. Migração de Assets Estáticos
  - `[x]` Mapear SCSS do Bootstrap 5 / Uena e compilar/inserir no Moodle.
  - `[x]` Copiar Fontes e Ícones do template Uena.
  - `[x]` Copiar Imagens, Logos e JS essenciais.
- `[x]` 4. Adaptação de Navegação
  - `[x]` Modificar `navbar.mustache` (Header Uena) via CSS.
  - `[x]` Modificar `drawer.mustache` (Sidebar Uena) via CSS.
  - `[x]` Injetar regras CSS para topo e sidebar no `lib.php`.
  - `[x]` Aplicar as mudanças no container e limpar cache.
- `[x]` 5. Validação
  - `[x]` Testar responsividade e botões nativos.
- `[x]` 6. Adaptação de Componentes Uena
  - `[x]` Copiar arquivos SCSS vitais (Tabelas, Alertas, Badges, Dropdowns, Modais).
  - `[x]` Injetar `@import` no `lib.php` para o compilador SCSS do Moodle.
  - `[x]` Aplicar as mudanças no container e limpar cache.
- `[x]` 7. Cabeçalho Uena e Dark Mode
  - `[x]` Criar arquivo SCSS `_dark-mode.scss` e injetar em `lib.php`.
  - `[x]` Criar módulo AMD JavaScript (`darkmode.js`) para controle de localStorage.
  - `[x]` Atualizar `navbar.mustache` com botão de Lua/Sol e estrutura de pesquisa.
  - `[x]` Aplicar as mudanças no container e compile JavaScript.
  - `[x]` Garantia de funcionamento da navegação nativa do Moodle (Simetria de pastas corrigida).
- `[x]` 8. Widget de Acessibilidade
  - `[x]` Criar arquivo Javascript AMD `accessibility.js`.
  - `[x]` Adicionar estilos SCSS globais de acessibilidade em `lib.php` (escala de fonte, grayscale, alto contraste).
  - `[x]` Injetar o markup do widget flutuante em `footer.mustache`.
  - `[x]` Testar e depurar a responsividade, persistência no localStorage e botão Reset.
  - `[x]` Integrar widget oficial do VLibras para acessibilidade de tradução em Libras.
- `[x]` 9. Customização de Aparência (Painel de Estilo)
  - `[x]` Atualizar estilos globais em `lib.php` para usar Variáveis CSS para cores primárias, fontes de leitura e cabeçalho.
  - `[x]` Atualizar `accessibility.js` (AMD) para ler/salvar estilos no localStorage e mudar variáveis dinamicamente.
  - `[x]` Atualizar `footer.mustache` com a aba "Personalizar Aparência" e seus botões/seletores.
  - `[x]` Testar toda a persistência de aparência e compatibilidade de alto contraste.

---

## 📋 Tarefas Pendentes de Infraestrutura (Pós-Instalação)

- `[ ]` **1. Configurar o Cron Job do Moodle na VPS**
  - **Por que:** Vital para o Moodle enviar e-mails de cadastro, notificações de fóruns, processar notas e limpar arquivos temporários.
  - **Como fazer:**
    1. Acesse o terminal da sua VPS via SSH.
    2. Abra o agendador de tarefas do sistema operacional rodando: `crontab -e`.
    3. Cole a seguinte linha no final do arquivo:
       ```text
       * * * * * docker exec $(docker ps -qf name=moodle | head -n1) php /var/www/html/admin/cli/cron.php >/dev/null 2>&1
       ```
    4. Salve e feche o arquivo.

- `[ ]` **2. Configurar o Envio de E-mails de Saída (SMTP)**
  - **Por que:** Evita que os e-mails enviados pelo Moodle caiam na caixa de spam dos alunos ou sejam bloqueados.
  - **Como fazer:**
    1. Faça login como administrador no Moodle.
    2. Vá em `Administração do site > Servidor > E-mail > Configurações de envio de e-mail`.
    3. Insira as credenciais do seu servidor SMTP corporativo ou serviço dedicado (como SendGrid, Mailgun, Amazon SES).

- `[ ]` **3. Validar Limite de Memória no Easypanel**
  - **Por que:** Garante estabilidade quando múltiplos alunos estiverem acessando cursos simultaneamente.
  - **Como fazer:**
    1. Vá no painel do Easypanel > Moodle > aba Environment.
    2. Garanta que a variável `PHP_MEMORY_LIMIT` está configurada como `512M`.

