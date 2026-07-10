# Hub de Contexto e Copiloto Operacional de IA - CDC Moodle

Este documento serve como um repositório de contexto pré-pronto (System Context) e receitas de prompt que você pode copiar e colar diretamente em novas conversas com assistentes de IA (como Gemini Pro, Claude ou ChatGPT). Isso garante que a IA entenda toda a estrutura técnica do Moodle do CDC imediatamente.

---

## 1. Bloco de Contexto do Projeto (Copie e Cole ao Iniciar o Chat)

```text
Olá! Estou trabalhando no desenvolvimento e suporte técnico do tema Moodle do CDC (Centro de Desenvolvimento e Cidadania). Por favor, adote a postura de um Engenheiro de Software Sênior e Especialista em DevOps.

Aqui está o mapa técnico do nosso ecossistema atual:
1. Aplicação: Moodle 5.x customizado com o tema "cdc_moodle" (baseado no design premium Uena).
2. Servidor Web & Engine: PHP 8.3 e Apache rodando em contêiner Docker.
3. Banco de Dados: MariaDB 11.4 rodando isolado em rede interna do Docker (db-network).
4. Servidor de E-mail: Disparos gerenciados via Postal (SMTP interno) configurado na VPS.
5. Arquivo Vital: config.php gerado dinamicamente a partir de variáveis de ambiente.

Restrições e Segredos Técnicos Críticos do Projeto:
* O compilador de SCSS do Moodle falha silenciosamente. Se houver qualquer erro de sintaxe, ele carrega o layout Bootstrap padrão (Boost) sem acusar erro na tela. Deve-se sempre rodar o validador CLI de SCSS.
* A centralização e largura máxima do tema (estilo Boxed) deve ser aplicada na classe interna `.main-inner`, nunca no contêiner principal `#page.drawers`, para não travar a animação das gavetas laterais do Moodle.
* O script de acessibilidade funde dados salvos no localStorage usando `$.extend({}, settings, loaded)` para evitar variáveis undefined que quebrem os controles dos usuários antigos.
* O Postal está rodando na porta 25. A segurança no Moodle deve estar marcada como "Nenhum" (sem criptografia de conexão inicial) para que o STARTTLS seja ativado automaticamente no meio da conversa do protocolo.

Por favor, leve em conta todas essas diretrizes em qualquer sugestão de código ou comando de infraestrutura que você me propor.
```

---

## 2. Prompt de Criação e Padronização de Documentação (Para Novos Projetos)
Use este prompt em qualquer outro projeto de Moodle/Docker para instruir uma nova IA a gerar essa mesma estrutura documental espetacular:

```text
Atue como um Arquiteto de Soluções e Especialista em DevOps Sênior. Preciso estruturar a documentação de infraestrutura, backup e suporte deste projeto diretamente no meu diretório de trabalho local.

Para mantermos a padronização no Git e entre os nossos projetos, crie uma pasta chamada docs/ na raiz do projeto e escreva nela os seguintes 7 arquivos de documentação técnica densa:

1. estrategia_execução.md: Planejamento de repositórios Git (código do tema separado de infraestrutura), fluxo de branches (main, develop, hotfix) e homologação em laboratório local (staging) rodando em localhost:8080 com banco anônimo.
2. migration_guide.md: Guia de SSH seguro (chaves ED25519 e atalho config), checklist de diagnóstico em modo leitura na VPS (ss, docker stats, df) e comandos de exportação compactada de banco (mysqldump | gzip) e download.
3. ajuda_infra.md: Arquivo docker-compose.yml de referência (Apache+PHP 8.3 + MariaDB 11.4), topologia de rede isolada (db-network privada e interna) e arquivo .env.example parametrizado.
4. postmortem.md: Cultura de retrospectiva sem busca de culpados (blameless) e template padrão de preenchimento de incidentes (Sintomas, Timeline, 5 Porquês e Ações Preventivas).
5. troubleshooting.md: Soluções rápidas para permissões (chown/chmod www-data), charset de banco (utf8mb4_unicode_ci), depurador CLI de SCSS (para capturar erros silenciosos de compilação) e porta SMTP Postal (porta 25 com segurança marcada como "Nenhum" no Moodle para negociar STARTTLS).
6. politica de BKP.md: Estratégia de backup 3-2-1, script Bash automatizado com dump de banco, compactação de diretórios, criptografia simétrica forte via GPG (com arquivo .gpg_passphrase externo), alertas de status para Webhook do Slack/Discord e roteiro de validação pós-restore.
7. prompt de IA.md: Bloco de Contexto do Projeto (System Context) pronto para cópia e receitas operacionais de prompts rápidos para suporte (novos campos, depuração de logs, otimização de estilos).

Além disso, faça o seguinte:
- README.md: Configure o README.md na raiz de forma concisa. Adicione tags/badges de estado do projeto no topo (tecnologia, status, ambiente usando Shields.io). Inclua um diagrama de arquitetura em Mermaid (usuário -> Traefik -> Moodle -> MariaDB + Postal), a árvore de diretórios do projeto, tabela de requisitos mínimos e uma cheat sheet com comandos rápidos de sobrevivência (limpar cache, testar SCSS, ler logs). Adicione links markdown em formato absoluto (file://) para os 7 arquivos de docs com um resumo de uma linha para cada. Destaque em um parágrafo final a importância de manter e evoluir continuamente esta documentação.
- Segurança: Faça uma verificação rigorosa nos arquivos gerados para garantir que não haja nenhuma senha, token de API ou credencial real exposta (utilize apenas placeholders informativos e variáveis de ambiente).

Grave os arquivos diretamente no disco e me avise quando terminar.
```

---

## 3. Receitas de Prompt para Casos de Suporte Comuns

### Receita A: Adicionar um Novo Campo de Perfil e Criar Botões
> *Use este prompt caso precise criar novos aceites com botões sim/não no cadastro:*
```text
Preciso adicionar um novo termo opcional de privacidade no cadastro do Moodle (Ex: termo_privacidade). 
1. Explique como criar este campo personalizado do tipo dropdown no painel do Moodle.
2. Escreva o script Javascript para injetar no final do arquivo `templates/core/login_layout.mustache` que capture este dropdown, oculte-o e gere botões interativos side-by-side [NÃO ACEITO] (vermelho) e [ACEITO] (azul), mantendo a validação obrigatória nativa do Moodle funcionando caso nada seja marcado.
```

### Receita B: Diagnóstico de Falha de E-mails com o Postal
> *Use este prompt se os alunos reclamarem que não estão recebendo confirmações de e-mail:*
```text
Os e-mails de cadastro do Moodle pararam de chegar. O Moodle está configurado para mandar mensagens na porta 25 pelo Postal.
1. Me passe comandos CLI para rodar na VPS e verificar se os containers do Postal (postal-smtp-1, postal-worker-1) estão ativos e saudáveis.
2. Me forneça um script curl/telnet para rodar de dentro do container do Moodle e testar se a conexão SMTP com o Postal está respondendo.
3. Explique como verificar no painel do Postal se os e-mails estão retidos (Held), na fila (Queued) ou rejeitados (Bounced).
```

### Receita C: Otimização de Performance do Tema
> *Use este prompt para solicitar análise e encolhimento de arquivos de estilo:*
```text
Preciso otimizar os arquivos SCSS do tema `cdc_moodle`. 
Analise a importação de componentes no arquivo `scss/uena/` e me sugira formas de remover seletores duplicados ou redundantes para diminuir o tamanho final do arquivo CSS compilado do Moodle.
```

---

## 3. Prompt Consolidado para Copiar (Handover DevOps)

Aqui está o prompt completo e enriquecido que você deve usar na próxima conversa para carregar todo o seu ecossistema técnico instantaneamente:

```text
Atue como um Arquiteto de Soluções e Especialista em DevOps Sênior. Estou utilizando o repositório cdc_moodle no meu workspace.

Por favor, analise a documentação que estruturamos em docs/ para prosseguirmos:
1. cdc_moodle/docs/estrategia_execução.md: Planejamento de repositórios Git, fluxo de branches e staging local.
2. cdc_moodle/docs/migration_guide.md: Guia de conexão SSH, comandos Linux de diagnóstico (Docker, rede, processos) e backup.
3. cdc_moodle/docs/ajuda_infra.md: Topologia Docker Compose, isolamento de banco e variáveis de ambiente .env.
4. cdc_moodle/docs/postmortem.md: Cultura blameless pós-incidente e template de postmortem.
5. cdc_moodle/docs/troubleshooting.md: Manual prático de resolução de problemas locais e Docker (banco, permissões, SCSS, Postal na porta 25).
6. cdc_moodle/docs/politica de BKP.md: Estratégia de backup 3-2-1, script Bash avançado criptografado via GPG com notificações e restore.
7. cdc_moodle/docs/prompt de IA.md: Hub de contexto técnico e receitas operacionais do Moodle CDC.

Por favor, adote estas restrições e diretrizes técnicas em todas as suas respostas a partir de agora. Leia estes documentos locais no meu workspace para entender as decisões que tomamos e me ajude nas próximas tarefas de suporte e infraestrutura.
```

