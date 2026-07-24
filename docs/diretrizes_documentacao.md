# Diretrizes de Documentação e Governança - CDC

Este documento estabelece as regras, princípios, fluxos operacionais e governança para a manutenção e evolução contínua da documentação técnica dos sistemas do CDC.

---

## Objetivo da Documentação

A documentação técnica existe no CDC para garantir a continuidade operacional e a autonomia das equipes de desenvolvimento e infraestrutura. Ela visa:
* **Reduzir dependência:** Eliminar silos de conhecimento informal ou histórico não registrado.
* **Acelerar onboarding:** Facilitar a introdução de novos desenvolvedores e DevOps no ambiente.
* **Histórico de decisões:** Manter um registro das decisões de design e escolhas arquiteturais.
* **Segurança e conformidade:** Fornecer regras rígidas contra vazamento de credenciais e auditoria de sistemas.
* **Mitigação de desastres:** Permitir que rotinas de backup, rollback e restore sejam feitas com precisão cirúrgica por qualquer pessoa técnica do CDC.

---

## Princípios da Documentação

1. **Documentação como código:** Toda documentação deve viver junto ao código no repositório Git, sob controle de versão.
2. **Atualização concorrente:** Qualquer alteração no sistema (código, infraestrutura, portas) deve vir acompanhada da atualização do manual correspondente no mesmo commit.
3. **Segurança por Padrão (Security by Design):** Dados confidenciais, IPs reais de servidores internos, senhas, tokens de API ou webhooks jamais devem entrar na documentação. Sempre utilize placeholders padronizados.
4. **Alinhamento do Mattermost:** Integrações com bots ou webhooks operacionais de alertas no Mattermost devem seguir a risca os formatos de notificação estipulados e os canais corretos.

---

## Estrutura Oficial de Documentos

A documentação corporativa na pasta `docs/` é estruturada em nove arquivos técnicos:

| Arquivo | Finalidade |
| :--- | :--- |
| `diretrizes_documentacao.md` | Regras, governança, checklists de PR e evolução dos manuais do projeto. |
| `estrategia_execucao.md` | Planejamento de branches Git, ambientes de staging, homologação e promoção de versões. |
| `migration_guide.md` | Comandos SSH, auditorias seguras (read-only) e migração de servidores antigos para Docker. |
| `ajuda_infra.md` | Mapeamento Docker Compose, topologia de rede isolada por serviço e variáveis `.env.example`. |
| `postmortem.md` | Cultura de análise sem culpa (*blameless*) pós-incidente e template estruturado de relatório. |
| `troubleshooting.md` | Guia passo a passo para corrigir erros frequentes de permissão, banco, SCSS, SMTP ou Mattermost. |
| `politica_backup.md` | Política de backup 3-2-1, script Bash criptografado via GPG com alertas e plano de restore. |
| `prompt_ia.md` | Contexto de sistema (System Context) e receitas de prompt prontas para co-pilotagem por IA. |
| `backlog_issues.md` | Templates de GitHub Issues prontos para cadastrar tarefas pendentes operacionais e de infraestrutura. |

---

## Regras de Atualização e Responsabilidades

A documentação deve ser obrigatoriamente revisada e atualizada em qualquer um dos seguintes eventos:
* **Mudança de infraestrutura:** Alteração de portas expostas, novos contêineres ou volumes persistentes (`ajuda_infra.md`).
* **Promoção ou Deploy:** Mudanças no fluxo Git ou novos critérios de homologação (`estrategia_execucao.md`).
* **Backups ou Restore:** Ajustes de retenção ou novas chaves GPG (`politica_backup.md`).
* **Incidentes e Soluções:** Resolução de downtimes (`postmortem.md`) e descoberta de soluções para problemas recorrentes (`troubleshooting.md`).
* **Mudanças no Mattermost:** Inclusão de novos webhooks de integração ou alertas operacionais.

### Responsabilidades da Equipe:
* **Desenvolvedores:** Devem revisar se as mudanças de código impactam os layouts ou arquivos dinâmicos (e atualizar o `README.md` ou `troubleshooting.md` caso necessário).
* **DevOps / SysAdmin:** Responsáveis por manter atualizados os arquivos de ajuda de infraestrutura, manuais de migração, políticas de backup e segredos.
* **Líder Técnico:** Garantir que nenhum Pull Request seja mesclado sem que a documentação tenha sido atualizada.

---

## Fluxo Recomendado no Git

As alterações na documentação devem seguir o fluxo padrão de branches. Nunca comite correções diretamente na `main`.
1. Crie uma branch a partir de `develop` (ex: `docs/atualizar-backup-mattermost`).
2. Faça as correções dos arquivos Markdown.
3. Utilize mensagens de commit padronizadas:
   * `docs: atualizar procedimento de backup no Mattermost`
   * `docs: adicionar solucao para erro de compilacao de SCSS`
   * `docs: documentar variaveis de ambiente no ajuda_infra`
4. Abra um Pull Request e anexe o checklist de revisão técnica.

---

## Checklist de Qualidade para Pull Requests (PR)

Antes de mesclar qualquer alteração para a branch de desenvolvimento ou produção, valide os itens abaixo:

- [ ] Esta alteração modifica a arquitetura ou os contêineres Docker do projeto?
- [ ] Foram criadas, removidas ou alteradas variáveis de ambiente? (Se sim, o `.env.example` foi atualizado?)
- [ ] Foram incluídos comandos operacionais ou scripts adicionais? (Eles foram validados e estão completos?)
- [ ] O código utiliza alertas ou webhooks do Mattermost?
- [ ] A documentação afetada pelas alterações acima foi devidamente atualizada?
- [ ] Os arquivos criados/modificados seguem o padrão snake_case de nomenclatura (sem espaços ou acentos)?
- [ ] Foi feita a checagem de segurança (nenhum token, senha real ou webhook real exposto nos markdowns)?
- [ ] Todos os links relativos internos estão funcionando perfeitamente?

---

## Segurança e Gestão de Segredos

### Placeholders Oficiais e Seguros:
Utilize unicamente os seguintes placeholders para exemplificar chaves e credenciais:
* `<DB_PASSWORD>` (senha do banco de dados)
* `<MATTERMOST_WEBHOOK_URL>` (URL do webhook do Mattermost)
* `<MATTERMOST_CHANNEL>` (canal de alertas)
* `<SMTP_PASSWORD>` (senha SMTP do Postal)
* `<SSH_HOST>` (IP ou host de acesso SSH)
* `<SSH_USER>` (usuário SSH)

Sempre garanta que arquivos confidenciais permaneçam declarados no `.gitignore` para evitar envio acidental:
```gitignore
.env
.env.*
!.env.example
.gpg_passphrase
backups/
dumps/
```
