# EAD CDC - Centro de Desenvolvimento e Cidadania

![Moodle Version](https://img.shields.io/badge/Moodle-5.x-orange?logo=moodle&logoColor=white)
![Postal Version](https://img.shields.io/badge/Postal-3.3.7-blue?logo=mail.ru&logoColor=white)
![Docker Compose](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-11.4-blue?logo=mariadb&logoColor=white)
![Status](https://img.shields.io/badge/Status-Ativo-green)

Este diretório contém os códigos-fonte, pacotes compilados e guias arquiteturais para a plataforma de EAD do **CDC**, com o tema customizado **CDC Moodle** (baseado no design premium Uena) e infraestrutura baseada em Docker.

---

## 🚀 Guias e Documentação de Infraestrutura e DevOps

Abaixo estão os links para os documentos técnicos detalhados disponíveis no diretório `docs/`:

1. 📂 **[Estratégia de Execução](file:///home/vier/Documentos/Code/Temas/moodle/cdc_moodle/docs/estrategia_execu%C3%A7%C3%A3o.md):** Planejamento de repositórios Git separados para tema e infraestrutura, e o fluxo de testes em ambiente de staging local.
2. 📖 **[Manual de Migração e Auditoria](file:///home/vier/Documentos/Code/Temas/moodle/cdc_moodle/docs/migration_guide.md):** Manual de conexões SSH, comandos Linux de diagnóstico em modo leitura e scripts para download e backup da VPS.
3. 🐳 **[Guia de Infraestrutura e Docker](file:///home/vier/Documentos/Code/Temas/moodle/cdc_moodle/docs/ajuda_infra.md):** Desenho completo da topologia de rede isolada do MariaDB, do arquivo `docker-compose.yml` e modelo de variáveis `.env.example`.
4. 📋 **[Cultura e Template de Post-Mortem](file:///home/vier/Documentos/Code/Temas/moodle/cdc_moodle/docs/postmortem.md):** Diretrizes para análise retrospectiva sem culpa de falhas no servidor e template padrão de relatório de incidentes.
5. 🛠️ **[Manual de Resolução de Problemas (Troubleshooting)](file:///home/vier/Documentos/Code/Temas/moodle/cdc_moodle/docs/troubleshooting.md):** Soluções práticas para permissões de escrita, travamento de charset no banco, depurador de SCSS e portas SMTP do Postal.
6. 💾 **[Política de Backup e Recuperação](file:///home/vier/Documentos/Code/Temas/moodle/cdc_moodle/docs/politica%20de%20BKP.md):** Planejamento de backup 3-2-1, script Bash avançado criptografado via GPG com notificações Discord/Slack e roteiro de restore.
7. 🤖 **[Hub de Contexto e Prompts de IA](file:///home/vier/Documentos/Code/Temas/moodle/cdc_moodle/docs/prompt%20de%20IA.md):** Prompt de System Context e receitas prontas para interações ágeis e co-pilotagem de suporte com Inteligências Artificiais.

---

## 💡 A Importância de Manter a Documentação Viva

Esta documentação foi concebida não apenas como um histórico estático, mas como um **ativo operacional crítico** da equipe de tecnologia do CDC. O Moodle e o Postal rodam sob infraestruturas de microsserviços integradas cuja topologia e segredos técnicos devem permanecer claros. É dever de cada desenvolvedor, engenheiro de DevOps e assistente de inteligência artificial revisar, testar e **atualizar continuamente estes guias** a cada nova atualização de layout, migração de rede ou correção aplicada ao ecossistema, prevenindo retrabalhos e garantindo a continuidade do conhecimento.
