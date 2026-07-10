# PROMPT — DOCUMENTAÇÃO PADRONIZADA DE INFRAESTRUTURA, BACKUP, SUPORTE, MATTERMOST E GOVERNANÇA

Este arquivo serve como o modelo de instrução oficial (Prompt) utilizado para gerar a documentação padronizada deste e de outros projetos de DevOps e desenvolvimento na empresa.

---

## Como usar este Prompt:
Copie todo o conteúdo abaixo e cole ao iniciar uma nova conversa com uma IA assistente (como Gemini Pro, Claude ou ChatGPT) em um novo repositório para gerar automaticamente toda a estrutura documental do projeto.

---

```text
Atue como um Arquiteto de Soluções, Engenheiro DevOps, Especialista em Segurança e Especialista em Documentação Técnica Sênior.

Sua missão é analisar o projeto atualmente aberto e estruturar, diretamente no diretório local de trabalho, uma documentação técnica completa sobre:
* Arquitetura;
* Infraestrutura;
* Desenvolvimento;
* Implantação;
* Migração;
* Backup;
* Restauração;
* Segurança;
* Manutenção;
* Resolução de problemas;
* Suporte;
* Alertas e comunicação pelo Mattermost;
* Uso de inteligência artificial;
* Governança e atualização contínua da documentação.

A documentação deve seguir um padrão reutilizável entre diferentes projetos, mas precisa refletir fielmente as tecnologias, serviços, diretórios, dependências, portas, volumes e configurações realmente encontrados no projeto analisado.

Além dos documentos técnicos, registre dentro da própria pasta docs/ as diretrizes usadas para produzir, revisar e manter essa documentação.
O objetivo é preservar no repositório uma visão documentada das decisões, padrões e práticas adotados atualmente.

---

# 1. REGRAS GERAIS

Antes de criar ou alterar qualquer arquivo:

1. Analise toda a estrutura atual do projeto.
2. Leia os arquivos de configuração relevantes antes de produzir a documentação.
3. Identifique automaticamente:
   * Nome do projeto;
   * Objetivo principal;
   * Linguagens utilizadas;
   * Frameworks;
   * Bibliotecas principais;
   * Banco de dados;
   * Serviços externos;
   * Containers existentes;
   * Arquivos Docker;
   * Arquivos Docker Compose;
   * Variáveis de ambiente;
   * Portas utilizadas;
   * Volumes persistentes;
   * Redes Docker;
   * Proxy reverso;
   * Servidor web;
   * Runtime;
   * Sistemas de cache;
   * Filas;
   * Tarefas agendadas;
   * Serviços de e-mail;
   * Integrações com Mattermost;
   * Ferramentas de monitoramento;
   * Estratégia atual de implantação;
   * Scripts de manutenção;
   * Scripts de backup;
   * Estrutura de branches, quando identificável;
   * Dependências de infraestrutura;
   * Regras de segurança existentes.
4. Não invente tecnologias, serviços, portas, domínios, credenciais ou processos.
5. Quando uma informação não puder ser determinada, utilize um marcador explícito:
   <TODO: DEFINIR — explicar exatamente qual informação precisa ser confirmada>
6. Não deixe um marcador TODO sem explicar o que precisa ser definido.
7. Preserve documentos e configurações já existentes.
8. Antes de substituir conteúdo, incorpore as informações relevantes existentes.
9. Não remova informações úteis sem justificativa.
10. Utilize linguagem técnica, clara, objetiva e adequada para:
    * Desenvolvedores;
    * Profissionais de infraestrutura;
    * Equipes de suporte;
    * Administradores de sistemas;
    * Gestores técnicos;
    * Novos integrantes do projeto.
11. Todos os exemplos devem ser executáveis ou facilmente adaptáveis.
12. Não utilize reticências para omitir partes importantes de comandos, scripts ou configurações.
13. Não use expressões como:
    * “Continue da mesma forma”;
    * “O restante segue o mesmo padrão”;
    * “Adicione os demais serviços”;
    * “Complete conforme necessário”.
14. Sempre diferencie:
    * Configurações encontradas no projeto;
    * Configurações recomendadas;
    * Valores apenas ilustrativos.
15. Salve todos os arquivos em UTF-8.
16. Utilize nomes de arquivos sem espaços e sem caracteres especiais.
17. Sempre que possível, utilize links Markdown relativos.
18. Não crie links absolutos dependentes de um computador específico.
19. Não modifique arquivos de produção sem necessidade.
20. Não execute comandos destrutivos.
21. Não remova volumes, bancos, arquivos persistentes ou containers com dados.
22. Não faça alterações irreversíveis sem documentar uma opção de rollback.
23. Não exponha segredos em documentação, logs, exemplos, comandos ou mensagens do Mattermost.
24. Todos os arquivos gerados ou alterados devem ser gravados diretamente no disco.
25. Antes de encerrar, valide que os arquivos realmente existem e possuem conteúdo.

---

# 2. ESTRUTURA DA DOCUMENTAÇÃO

Na raiz do projeto, crie ou atualize a pasta:
docs/

Dentro dela, crie ou atualize os seguintes oito arquivos:
docs/
├── diretrizes_documentacao.md
├── estrategia_execucao.md
├── migration_guide.md
├── ajuda_infra.md
├── postmortem.md
├── troubleshooting.md
├── politica_backup.md
└── prompt_ia.md

O arquivo diretrizes_documentacao.md será o documento central de governança da documentação.
Ele deverá registrar:
* Por que a documentação existe;
* Como os documentos estão estruturados;
* Quando devem ser atualizados;
* Quem deve atualizá-los;
* Como verificar se continuam corretos;
* Quais cuidados de segurança devem ser seguidos;
* Como registrar mudanças futuras;
* Como evitar que a documentação fique desatualizada;
* Como manter o Mattermost integrado aos processos operacionais;
* Como proteger os webhooks e demais segredos.

---

# 3. CONTEÚDO DOS ARQUIVOS

## 3.1 `docs/diretrizes_documentacao.md`
Crie um documento permanente contendo as regras de criação, organização, manutenção e evolução da documentação do projeto.
O objetivo é preservar no próprio repositório o entendimento atual sobre como a documentação deve funcionar.
Inclua:
* Objetivo da documentação;
* Princípios (documentação como parte do projeto, atualização junto com código, segurança por padrão);
* Tabela de Estrutura oficial;
* Regras de atualização (quando mudar tecnologia, versão, porta, etc.);
* Responsabilidades da equipe;
* Fluxo recomendado no Git (commits padrão docs:);
* Controle de versões (data de última revisão);
* Tabela de revisão periódica;
* Critérios de qualidade (atual, claro, localizável, seguro);
* Informações proibidas (segredos, webhooks reais);
* Placeholders oficiais;
* Checklist para pull requests;
* Registro de decisões (ADRs);
* Processo de descontinuação de manuais;
* Validação técnica da documentação.

## 3.2 `docs/estrategia_execucao.md`
Crie um documento descrevendo a estratégia de desenvolvimento, versionamento, homologação e implantação do projeto.
Inclua:
* Visão geral (objetivo do projeto, ambientes, Mattermost);
* Organização dos repositórios (código vs infraestrutura);
* Estratégia de branches (main, develop, feature, hotfix, pull requests);
* Ambientes (Desenvolvimento, Staging, Produção com portas, bancos e restrições);
* Fluxos funcionais importantes (assistentes progressivos, wizard em etapas);
* Critérios de promoção (testes passados, backup feito, aprovação técnica);
* Comunicação de deploy e alertas pelo Mattermost;
* Plano de Rollback detalhado (código, banco, containers, proxy).

## 3.3 `docs/migration_guide.md`
Crie um guia de migração, diagnóstico e acesso seguro a servidores.
Inclua:
* Acesso SSH seguro (ED25519, SSH config, desativação de password/root login, sudo);
* Diagnóstico em modo somente leitura (ss, docker stats, free, df, resolução DNS, teste Mattermost);
* Preparação para migração (checklist de congelamento, inventário, checksums);
* Exportação do banco de dados (comandos mysqldump sem expor senhas na linha);
* Compactação e transferência (tar, gzip, rsync, scp, verificação SHA-256);
* Comunicação da migração no Mattermost (início, andamento, normalização);
* Validação pós-migração (teste de rotas, banco, e-mail, uploads, webhooks).

## 3.4 `docs/ajuda_infra.md`
Crie um guia técnico da infraestrutura do projeto.
Inclua:
* Arquitetura atual (Aplicação, Proxy, MariaDB, SMTP, volumes, cron);
* Containers (docker-compose.yml de referência completo com healthchecks, limites e redes);
* Isolamento de rede (redes db-network internal privada e web-network pública);
* `.env.example` completo (placeholders fictícios e seguros para todas as variáveis, incluindo as de banco, SMTP e Mattermost);
* Integração com o Mattermost (endereço, webhooks de entrada, formato das mensagens, segurança da webhook);
* Teste do Mattermost (comando curl seguro com variáveis);
* DNS e serviços externos (A, CNAME, TXT, SPF, DKIM, Return Path, tabela de DNS);
* Portas (tabela de mapeamento de portas internas e externas);
* Inicialização e encerramento (comandos up, down, logs, status).

## 3.5 `docs/postmortem.md`
Crie um documento para orientar a análise de incidentes com cultura blameless, sem procura por culpados.
Inclua:
* Identificação do incidente (data, severidade, canal Mattermost);
* Resumo executivo (o que houve, impacto, detecção);
* Sintomas e Impacto (erros observados, usuários afetados, duração);
* Timeline (tabela contendo horário do alerta, investigação, mitigação, restauração);
* Detecção e Resposta (como foi descoberto, eficácia das mensagens do Mattermost);
* Causa raiz (metodologia dos 5 Porquês);
* Fatores contribuintes (infra, processos, falta de testes/capacidade);
* O que funcionou e o que não funcionou;
* Comunicação (qualidade das atualizações no canal Mattermost);
* Ações corretivas e preventivas (tabela com tipo, prioridade, responsável, prazo);
* Lições aprendidas e evidências (commits, logs sanitizados).

## 3.6 `docs/troubleshooting.md`
Crie um manual de diagnóstico e resolução de problemas frequentes.
Inclua diagnóstico, correção e comandos de teste para:
* Containers (reiniciando, falha de volume/porta/rede/healthcheck);
* Permissões (www-data em moodledata, chown/chmod mínimo, sem chmod 777);
* Banco de dados (conexão recusada, charset/collations, tabelas corrompidas);
* Aplicação (cache local, sessões, compilação de assets, SCSS/CSS com falha silenciosa);
* Interface (layouts desalinhados, responsividade, formulários, persistência LocalStorage);
* E-mail (firewall, portas, segurança SMTP TLS/STARTTLS/Nenhum);
* Mattermost (webhooks inválidos/bloqueados, erros 400/403/404, firewall, timeout);
* Logs (comandos para cauda de logs, filtragem de erros, sanitização de logs);
* Checklist de emergência (disco, memória, contêineres, portas, banco, Mattermost).

## 3.7 `docs/politica_backup.md`
Crie uma política completa de backup e restauração.
Inclua:
* Estratégia 3-2-1;
* Escopo do backup (banco de dados, arquivos moodledata, ignorando cache/temp);
* Frequência e Retenção (diário, semanal, RPO, RTO);
* Script Bash automatizado (`set -Eeuo pipefail`, dump compactado, tar.gz, hash SHA-256, criptografia GPG simétrica externa, webhook Mattermost, trap);
* Arquivo de configuração do backup (variáveis externas seguras);
* Segredos (.gpg_passphrase com chmod 600);
* Integração e alertas de backup no Mattermost (início, sucesso, falha no dump/criptografia/envio);
* Formato de mensagens do bot (projeto, servidor, tamanho do backup, checksum);
* Roteiro de restauração completo (descriptografar, verificar hash, restaurar db/moodledata, limpar caches);
* Validação pós-restore e teste periódico (frequência de testes, logs de auditoria).

## 3.8 `docs/prompt_ia.md`
Crie um documento de contexto para uso com assistentes de inteligência artificial.
Inclua:
* System Context (nome, objetivo, stack, portas, restrições operacionais específicas);
* Restrições obrigatórias (não expor segredos, não quebrar fallbacks, manter .env.example);
* Regras para respostas da IA (entregar código completo, sem reticências, validar resultados);
* Prompts rápidos (diagnóstico de erro, rebuild de container, backup, restore, testes de e-mail e Mattermost).

---

# 4. README PRINCIPAL

Na raiz do projeto, crie ou atualize:
README.md

O README deve ser conciso, mas suficiente para permitir que um novo integrante compreenda e inicialize o projeto.
* Cabeçalho (nome, descrição e badges Shields.io de stack, versão e status);
* Arquitetura (diagrama Mermaid cobrindo Proxy, App, DB, SMTP e alertas Mattermost);
* Estrutura de diretórios do repositório;
* Requisitos mínimos (CPU, RAM, espaço em disco);
* Configuração do ambiente (cópia de .env.example e aviso sobre segredos);
* Inicialização rápida;
* Cheat sheet operacional;
* Documentação complementar (links markdown relativos para os 8 arquivos criados em docs/ com um breve resumo de uma linha para cada);
* Parágrafo sobre a importância de manter a documentação atualizada.

---

# 5. SEGURANÇA

Faça uma revisão rigorosa de todos os arquivos criados ou alterados.
Verifique a presença de senhas, tokens, webhooks reais, credenciais de banco ou chaves privadas.
Utilize unicamente placeholders de formato oficial (ex: <DB_PASSWORD>, <MATTERMOST_WEBHOOK_URL>).
Assegure que arquivos de variáveis reais e chaves (.env, .env.*, .gpg_passphrase) estejam protegidos no .gitignore do projeto.
Realize buscas por padrões como password=, secret=, token=, api_key= para garantir a ausência de dados reais.

---

# 6. VALIDAÇÃO FINAL

Antes de concluir:
1. Confirme que a pasta docs/ existe e contém os oito arquivos.
2. Confirme que o README.md na raiz existe e possui links markdown relativos corretos.
3. Confirme a sintaxe dos blocos Mermaid.
4. Confirme que nenhuma credencial real ou webhook real do Mattermost foi vazado.
5. Mostre a árvore final dos arquivos criados.
6. Informe o resultado da validação e verificação de segurança.

---

# 7. FORMATO DA RESPOSTA FINAL

Após gravar os arquivos diretamente no disco, responda com:
```text
Documentação criada com sucesso.

Arquivos criados ou atualizados:
- README.md
- docs/diretrizes_documentacao.md
- docs/estrategia_execucao.md
- docs/migration_guide.md
- docs/ajuda_infra.md
- docs/postmortem.md
- docs/troubleshooting.md
- docs/politica_backup.md
- docs/prompt_ia.md

Tecnologias identificadas:
- <LISTAR>

Pendências encontradas:
- <LISTAR OU INFORMAR "Nenhuma">

Verificação de segurança:
- Nenhuma credencial real identificada nos arquivos gerados.
```
```
```
