# Cultura de Pós-Incidente e Template de Post-Mortem - CDC

A cultura de pós-incidente no **Centro de Desenvolvimento e Cidadania (CDC)** é orientada para o aprendizado e melhoria contínua, baseando-se no conceito de **Blameless Post-Mortem** (Retrospectiva Sem Culpa).

---

## 1. Princípios da Cultura Blameless (Sem Culpa)

* **Foco no Sistema, não nas Pessoas:** Quando ocorre um erro técnico, assumimos que as pessoas agiram com a melhor das intenções com as informações e ferramentas que tinham no momento. O objetivo do pós-incidente é descobrir **por que** o sistema falhou ou permitiu a falha, e não quem causou a falha.
* **Documentação Explícita:** Cada incidente grave que cause interrupção do sistema (Downtime), travamento de inscrições ou falha geral de e-mails deve gerar um relatório de pós-morte (Post-Mortem).
* **Foco nas Ações Preventivas:** O relatório só é considerado concluído quando ações concretas são mapeadas, com prazos e responsáveis definidos, para evitar que o exato mesmo erro aconteça novamente.

---

## 2. Template Padrão de Post-Mortem (Pronto para Preenchimento)

Utilize o modelo estruturado abaixo para documentar novos incidentes na infraestrutura:

```markdown
# Post-Mortem: [NOME DO INCIDENTE EM CAIXA ALTA]

**Autores:** [Nome dos envolvidos na análise]  
**Data do Incidente:** [DD/MM/AAAA]  
**Status do Relatório:** [Em Análise / Concluído / Ações Aplicadas]

---

## 1. Resumo Executivo
*Forneça um parágrafo resumindo o que aconteceu, qual o impacto percebido pelos usuários finais (ex: alunos não receberam e-mail de confirmação de cadastro durante 4 horas) e como o sistema foi restaurado.*

---

## 2. Sintomas e Impacto
* **Duração total do incidente:** [X horas e Y minutos]
* **Impacto operacional:** [Ex: Inscrições paralisadas, lentidão de carregamento, erros 502 Bad Gateway]
* **Quantos usuários foram afetados:** [Média estimada]

---

## 3. Linha do Tempo (Eventos Críticos)
*Registre de forma cronológica (com data e hora) a sequência de eventos desde a ocorrência do erro até a resolução:*
* **[HH:MM]** - O incidente teve início.
* **[HH:MM]** - O erro foi detectado via [Ex: Monitoramento automático / Ticket de suporte].
* **[HH:MM]** - Início da investigação pela equipe.
* **[HH:MM]** - Aplicação da ação de mitigação temporária [Ex: Reinício do container / Rollback].
* **[HH:MM]** - O tráfego e os serviços voltaram à normalidade.

---

## 4. Análise da Causa Raiz (Os 5 Porquês)
*Use a técnica dos "5 Porquês" para investigar a causa sistêmica do problema:*
1. **Por que o Moodle parou de enviar e-mails?** Porque a conexão SMTP na porta 587 foi recusada.
2. **Por que a conexão foi recusada?** Porque o Postal estava escutando e aceitando conexões na porta 25.
3. **Por que tentamos conectar na porta 587 se ele ouvia na porta 25?** Porque a documentação inicial do provedor apontava a 587 como padrão e o ambiente de testes local não simulou o servidor Postal ativo.
4. **Por que o teste local não simulou o Postal?** [Continue a lógica...]
5. **Por que...?** [Identifique a falha estrutural].

---

## 5. Ações Corretivas e Preventivas
*Mapeie as ações técnicas necessárias para blindar o sistema contra reincidência do mesmo problema:*

| Ação Preventiva / Corretiva | Tipo | Responsável | Prazo | Status |
| :--- | :--- | :--- | :--- | :--- |
| Ex: Atualizar porta SMTP no Moodle para `:25` | Imediato | [Nome] | [Data] | [Pendente/Concluído] |
| Ex: Inserir teste de ping e telnet no guia de migração | Preventivo | [Nome] | [Data] | [Pendente/Concluído] |
| Ex: Criar rotina de teste de disparo semanal | Longo Prazo | [Nome] | [Data] | [Pendente/Concluído] |
```
