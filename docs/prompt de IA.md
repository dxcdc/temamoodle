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

## 2. Receitas de Prompt para Casos de Suporte Comuns

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
