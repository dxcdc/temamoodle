# Backlog de Issues - CDC Moodle

Este arquivo contém os templates de **GitHub Issues** prontos para serem copiados e criados no repositório oficial do projeto (`dxcdc/temamoodle`). Eles representam as tarefas pendentes de infraestrutura, implantação, monitoramento e validação operacional.

---

## 📋 Lista de Issues Pendentes

### 1. Configurar o Cron Job do Moodle na VPS
* **Título:** `[Infra] Configurar o Cron Job do Moodle na VPS`
* **Labels:** `infraestrutura`, `prioridade-alta`, `producao`
* **Descrição:**
  ```markdown
  ### Descrição
  O agendador de tarefas interno do Moodle (Cron) é vital para o funcionamento correto do ecossistema. Sem ele, a plataforma não envia e-mails de cadastro, notificações de fóruns, alertas de notas ou limpezas automáticas de arquivos temporários.

  ### Como Implementar (Passo a Passo na VPS)
  1. Conecte-se à VPS via SSH:
     ```bash
     ssh root@76.13.227.135
     ```
  2. Abra o agendador de tarefas do sistema operacional:
     ```bash
     crontab -e
     ```
  3. Adicione a seguinte linha no final do arquivo (executando o php do cron como o usuário `www-data` dentro do container ativo):
     ```text
     * * * * * docker exec -u www-data cdc-ezpoint_moodle.1.xwi10emrzeha4xhzpmm2sy759 php /var/www/html/admin/cli/cron.php >/dev/null 2>&1
     ```
  4. Salve e saia do crontab.

  ### Critérios de Aceite
  - [ ] O Cron está rodando a cada minuto sem gerar erros de permissão de escrita.
  - [ ] Fila de e-mails do Moodle sendo esvaziada de forma contínua.
  - [ ] Logs do Moodle não exibem avisos de "Cron não está executando".
  ```

---

### 2. Ajustar e Validar o PHP Memory Limit no Easypanel
* **Título:** `[Performance] Ajustar PHP Memory Limit para 512M no Easypanel`
* **Labels:** `infraestrutura`, `performance`, `prioridade-media`
* **Descrição:**
  ```markdown
  ### Descrição
  Para garantir a estabilidade e performance do Moodle quando múltiplos alunos estiverem acessando cursos e executando tarefas concorrentes, precisamos configurar a memória máxima dedicada ao PHP.

  ### Como Implementar
  1. Acesse o painel de controle do **Easypanel**.
  2. Navegue até o aplicativo correspondente ao **Moodle**.
  3. Vá na aba de **Environment Variables** (Variáveis de Ambiente).
  4. Verifique ou crie a variável de ambiente:
     ```env
     PHP_MEMORY_LIMIT=512M
     ```
  5. Salve as configurações e force o redeploy do container.

  ### Critérios de Aceite
  - [ ] A variável `PHP_MEMORY_LIMIT` está configurada como `512M` (ou `1024M`).
  - [ ] Executar o comando PHP abaixo de dentro do container Moodle retorna o valor correto:
     ```bash
     docker exec -it cdc-ezpoint_moodle.1.xwi10emrzeha4xhzpmm2sy759 php -r "echo ini_get('memory_limit') . PHP_EOL;"
     ```
     *(Saída esperada: `512M`)*
  ```

---

### 3. Gerar Pacote ZIP e Instalar o Tema cdc_moodle em Produção
* **Título:** `[Deploy] Instalar e Ativar Tema cdc_moodle em Produção`
* **Labels:** `deploy`, `interface`, `prioridade-alta`
* **Descrição:**
  ```markdown
  ### Descrição
  As otimizações de CSS, os botões customizados de consentimento da LGPD e os templates Mustache do tema Uena estão prontos na branch `main`. Precisamos empacotar o diretório do tema e instalá-lo no Moodle em produção.

  ### Como Implementar
  1. Em sua máquina local, acesse a raiz do projeto (onde a pasta `cdc_moodle` está localizada).
  2. Execute o script Python para empacotar o tema sem incluir lixo ou dependências incorretas:
     ```bash
     python3 -c "import shutil; shutil.make_archive('cdc_moodle', 'zip', '.', 'cdc_moodle')"
     ```
  3. Acesse o painel administrativo do Moodle em produção: **Administração do site > Extensões > Instalar extensões**.
  4. Envie o arquivo `cdc_moodle.zip` gerado.
  5. Siga as etapas de atualização do banco de dados na tela do Moodle.
  6. Defina o tema ativo em: **Administração do site > Aparência > Seletor de temas** mudando para `cdc_moodle`.
  7. Purge os caches via CLI após a instalação:
     ```bash
     docker exec -it cdc-ezpoint_moodle.1.xwi10emrzeha4xhzpmm2sy759 php /var/www/html/admin/cli/purge_caches.php
     ```

  ### Critérios de Aceite
  - [ ] O tema `cdc_moodle` foi instalado com sucesso (sem falhas de compilação SCSS).
  - [ ] O botão de consentimento e LGPD está operando com botões SIM/NÃO.
  - [ ] A aparência e responsividade do tema Uena estão visíveis para todos os usuários.
  ```

---

### 4. Configurar Alertas e Webhook de Backup no Mattermost
* **Título:** `[Monitoramento] Configurar Webhook e Alertas do Backup no Mattermost`
* **Labels:** `monitoramento`, `seguranca`, `prioridade-media`
* **Descrição:**
  ```markdown
  ### Descrição
  Precisamos configurar as notificações automáticas de backup para que o administrador do CDC receba o status do backup semanal diretamente em um canal dedicado no Mattermost, garantindo conformidade com a governança da infraestrutura.

  ### Como Implementar
  1. No painel do Mattermost, vá em **Product Menu > Integrations > Incoming Webhooks**.
  2. Clique em **Add Incoming Webhook**, dê o nome de `BackupBot` e selecione o canal de alertas desejado.
  3. Copie a URL gerada (trate-a como segredo).
  4. Acesse a VPS de produção e edite o arquivo de configuração de backup `/opt/scripts/.env` ou o script de backup `/opt/scripts/backup.sh`:
     ```env
     MATTERMOST_ENABLED=true
     MATTERMOST_WEBHOOK_URL=https://<SUA_URL_DO_WEBHOOK_MATTERMOST>
     MATTERMOST_CHANNEL=<CANAL_DE_ALERTAS>
     ```
  5. Execute o script de backup manualmente uma vez para testar:
     ```bash
     /bin/bash /opt/scripts/backup.sh
     ```

  ### Critérios de Aceite
  - [ ] O backup foi executado com sucesso localmente.
  - [ ] O canal do Mattermost recebeu o card do alerta verde contendo o status, tamanho do backup e hash de integridade SHA-256.
  - [ ] O webhook real não foi exposto em nenhum repositório público do Git.
  ```

---

### 5. Validar Regras SPF/DKIM para o SMTP Postal no Registro.br
* **Título:** `[Segurança] Validar Entrada DMARC, SPF e DKIM no Registro.br para o SMTP`
* **Labels:** `seguranca`, `email`, `prioridade-alta`
* **Descrição:**
  ```markdown
  ### Descrição
  Os e-mails de teste do Moodle disparam corretamente pelo SMTP do Postal na porta 25. Porém, para evitar que os e-mails caiam na caixa de SPAM do Gmail/Outlook dos alunos, precisamos garantir que as regras DKIM e SPF estejam 100% corretas no Registro.br (respeitando o limite de 40 registros da conta).

  ### Como Implementar
  1. Acesse o painel administrativo do **Postal**.
  2. Vá na aba do domínio configurado (`cdc.org.br` ou subdomínio) e verifique os valores gerados de TXT para:
     - **SPF** (Ex: `v=spf1 include:postal.cdc.org.br ~all`)
     - **DKIM** (Chave pública gerada pelo Postal)
  3. Acesse a conta da zona de DNS no **Registro.br** (ou Hostinger).
  4. Adicione as duas entradas do tipo **TXT** contendo as chaves exatas fornecidas.
  5. Se o limite de 40 registros estiver estourado, remova registros CNAME ou MX obsoletos/antigos que não são mais lidos.
  6. Use ferramentas como `https://mxtoolbox.com` para testar e auditar se o domínio passa com sucesso no SPF e DKIM.

  ### Critérios de Aceite
  - [ ] Domínio CDC validado (SPF e DKIM marcados como verdes no painel do Postal).
  - [ ] Mensagens enviadas do Moodle passam pelo teste do DKIM Analyzer sem erros.
  ```
