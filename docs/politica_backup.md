# Política de Backup e Recuperação de Desastres - CDC Moodle

Este documento detalha o planejamento estratégico de backups e fornece o script automatizado de salvamento de banco de dados e arquivos com suporte a alertas e criptografia para o Moodle.

---

## 1. Estratégia de Backup 3-2-1

Seguimos a regra padrão de segurança do setor de infraestrutura:
* **3 Cópias dos Dados:** Ter no mínimo a base ativa de produção e mais duas cópias de segurança.
* **2 Mídias Diferentes:** Guardar os backups em locais diferentes (ex: o disco local da VPS e um armazenamento em nuvem S3 externo).
* **1 Cópia Offsite (Fora do Datacenter):** Manter pelo menos uma cópia do backup em um datacenter geograficamente isolado da VPS atual (como o Backblaze B2 ou AWS S3).

---

## 2. Script de Backup Automatizado (`backup.sh`)

Crie o script abaixo na VPS na pasta `/opt/scripts/backup.sh` e dê permissão de execução com `chmod +x backup.sh`. Ele realiza o dump do banco, compacta a pasta de arquivos, aplica **criptografia simétrica com o GPG**, remove backups mais antigos que 7 dias e envia alertas para um Webhook do Slack/Discord.

```bash
#!/bin/bash

# ==============================================================================
# CONFIGURAÇÕES DO BACKUP
# ==============================================================================
BACKUP_DIR="/var/backaps"
DATABASE_CONTAINER="cdc-ezpoint-moodle-db"
DB_USER="cdc_moodle_user"
DB_NAME="moodle_db"
MOODLEDATA_DIR="/var/www/moodledata"
PASSPHRASE_FILE="/opt/scripts/.gpg_passphrase" # Arquivo contendo a senha GPG (permissão 600)
WEBHOOK_URL="https://discord.com/api/webhooks/seu_webhook_aqui"
RETENTION_DAYS=7

TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_PATH="${BACKUP_DIR}/backup_${TIMESTAMP}"
mkdir -p "${BACKUP_PATH}"

# ==============================================================================
# FUNÇÃO DE NOTIFICAÇÃO VIA WEBHOOK
# ==============================================================================
send_notification() {
    local status=$1
    local message=$2
    local color=32768 # Verde para sucesso
    if [ "$status" = "ERRO" ]; then
        color=16711680 # Vermelho para erro
    fi
    
    curl -H "Content-Type: application/json" \
         -X POST \
         -d "{\"embeds\": [{\"title\": \"Moodle Backup Status: ${status}\", \"description\": \"${message}\", \"color\": ${color}}]}" \
         "${WEBHOOK_URL}"
}

# ==============================================================================
# INÍCIO DO BACKUP
# ==============================================================================
echo "Iniciando backup em $(date)"

# 1. Backup do Banco de Dados
DB_DUMP_FILE="${BACKUP_PATH}/db_backup.sql"
if docker exec "${DATABASE_CONTAINER}" mysqldump -u "${DB_USER}" -p"${DB_PASSWORD}" --databases "${DB_NAME}" > "${DB_DUMP_FILE}"; then
    echo "Dump do banco concluído com sucesso."
else
    send_notification "ERRO" "Falha ao gerar dump do banco de dados Moodle."
    exit 1
fi

# 2. Backup da pasta moodledata (ignora pastas de cache temporárias)
MOODLEDATA_TAR="${BACKUP_PATH}/moodledata_backup.tar.gz"
if tar -czvf "${MOODLEDATA_TAR}" --exclude='cache' --exclude='temp' --exclude='localcache' -C "${MOODLEDATA_DIR}/.." moodledata; then
    echo "Compactação da pasta moodledata concluída."
else
    send_notification "ERRO" "Falha ao compactar pasta moodledata."
    exit 1
fi

# 3. Criptografia dos arquivos via GPG
if [ -f "${PASSPHRASE_FILE}" ]; then
    gpg --batch --yes --passphrase-file "${PASSPHRASE_FILE}" --symmetric --cipher-algo AES256 "${DB_DUMP_FILE}"
    gpg --batch --yes --passphrase-file "${PASSPHRASE_FILE}" --symmetric --cipher-algo AES256 "${MOODLEDATA_TAR}"
    
    # Remover arquivos não criptografados
    rm "${DB_DUMP_FILE}"
    rm "${MOODLEDATA_TAR}"
    echo "Criptografia concluída com sucesso."
else
    send_notification "ERRO" "Arquivo de senha GPG não encontrado. Backups gerados sem criptografia."
fi

# 4. Compactar a pasta final do backup
tar -cf "${BACKUP_DIR}/backup_${TIMESTAMP}.tar" -C "${BACKUP_DIR}" "backup_${TIMESTAMP}"
rm -rf "${BACKUP_PATH}"

# 5. Limpar Backups Antigos (Retenção)
find "${BACKUP_DIR}" -type f -name "backup_*.tar" -mtime +${RETENTION_DAYS} -delete

send_notification "SUCESSO" "Backup semanal concluído e criptografado na pasta ${BACKUP_DIR}."
echo "Backup finalizado com sucesso."
```

---

## 3. Roteiro de Verificação Pós-Restauração (Restore Validation)

Sempre que precisar restaurar a plataforma a partir de um backup, execute estes passos de validação para garantir que o ambiente subiu sem corrupção de dados:

1. **Descriptografar os Arquivos:**
   ```bash
   gpg --batch --yes --passphrase-file /opt/scripts/.gpg_passphrase --decrypt db_backup.sql.gpg > db_backup.sql
   tar -xzvf moodledata_backup.tar.gz.gpg
   ```
2. **Restaurar Banco de Dados:**
   Importe a estrutura SQL e verifique se as tabelas de logs e de usuários carregaram.
3. **Limpar Caches do Moodle:**
   Após mover a pasta `moodledata` restaurada para o diretório correto, limpe os caches do Moodle via CLI para forçar a regeneração de dados de layout temporários:
   ```bash
   docker exec -it cdc-moodle-app php /var/www/html/admin/cli/purge_caches.php
   ```
4. **Validação Manual Crítica:**
   * Tente logar com um usuário de teste.
   * Entre em um curso e verifique se as imagens das aulas carregam corretamente (isso valida a integridade do diretório `moodledata`).
   * Tente cadastrar um novo usuário para garantir que o banco está aceitando novos registros (autoincrementos das tabelas intactos).
