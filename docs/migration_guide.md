# Manual de Migração e Auditoria de Servidores - CDC Moodle

Este guia reúne as orientações de infraestrutura para realizar conexões SSH seguras, mapear o ambiente de origem por meio de comandos de auditoria não destrutivos e gerar os backups de transição para a nova estrutura baseada em Docker.

---

## 1. Conexões SSH e Acesso Seguro

* **Recomendação de Chaves SSH:** Desative a autenticação por senha no arquivo `/etc/ssh/sshd_config` da VPS (`PasswordAuthentication no`) e utilize chaves criptográficas RSA (mínimo 4096 bits) ou ED25519.
* **Comando para Gerar Par de Chaves Local:**
  ```bash
  ssh-keygen -t ed25519 -C "admin@cdc.org.br"
  ```
* **Copiar Chave Pública para a VPS:**
  ```bash
  ssh-copy-id -i ~/.ssh/id_ed25519.pub root@76.13.227.135
  ```
* **Configuração de Atalho Local (`~/.ssh/config`):**
  Para facilitar o acesso rápido, crie o atalho abaixo na sua máquina pessoal:
  ```text
  Host cdc-vps
      HostName 76.13.227.135
      User root
      IdentityFile ~/.ssh/id_ed25519
  ```
  Isso permite conectar à VPS simplesmente digitando: `ssh cdc-vps`.

---

## 2. Checklist Seguro (Somente Leitura) para Auditoria de Origem

Sempre execute estes comandos para analisar a saúde, processos ativos e rede da VPS de origem sem alterar nenhum dado ativo:

### A. Diagnóstico de Portas de Rede e Conflitos
```bash
# Listar todas as portas TCP ouvindo conexões ativas na VPS
sudo ss -tulpn

# Verificar especificamente se o servidor de e-mail (Postal) ou SMTP está ativo localmente
sudo ss -tulpn | grep -E ':(25|587|465|2525)'
```

### B. Diagnóstico de Contêineres Docker
```bash
# Listar todos os contêineres rodando, portas expostas e tempo de atividade
docker ps

# Verificar o consumo de memória e CPU em tempo real de cada contêiner
docker stats --no-stream

# Inspecionar as redes criadas e identificar quais contêineres se comunicam
docker network ls
```

### C. Saúde do Sistema e Recursos da VPS
```bash
# Verificar consumo de memória RAM livre e usada
free -h

# Analisar o espaço em disco disponível nas partições montadas
df -h

# Exibir os processos que mais consomem CPU no momento
ps aux --sort=-%cpu | head -n 10
```

---

## 3. Comandos de Geração e Download de Backups

Para migrar a aplicação, você precisa extrair dois elementos cruciais da VPS antiga: a base de dados MySQL/MariaDB e a pasta física de arquivos enviados pelos usuários (`moodledata`).

### A. Exportar a Base de Dados (Database Dump)
Execute o dump comprimido da base diretamente a partir do contêiner ativo do banco de dados:
```bash
# Executa o dump dentro do contêiner e grava o arquivo compactado no host da VPS
docker exec cdc-ezpoint_moodle-db.1.pa8cso8lv687iqesl084h8gxa mysqldump -u cdc_moodle_user -p --default-character-set=utf8mb4 --databases moodle_db | gzip > /tmp/backup_moodle_db.sql.gz
```
*(Nota: Substitua `cdc_moodle_user` e `moodle_db` pelos dados reais extraídos do config.php).*

### B. Compactar o Diretório de Arquivos (`moodledata`)
A pasta `moodledata` contém arquivos de cursos, tarefas de alunos e logs. Como ela pode ser grande, compacte-a para economizar banda durante a transferência:
```bash
# Compacta a pasta de dados usando tar com compressão gzip
sudo tar -czvf /tmp/backup_moodledata.tar.gz -C /var/www/ moodledata
```

### C. Fazer o Download dos Backups para a Máquina Local (Staging)
Execute estes comandos **na sua máquina local (desenvolvimento)** para puxar os arquivos gerados na VPS:
```bash
# Baixar o dump do banco de dados
scp root@76.13.227.135:/tmp/backup_moodle_db.sql.gz ./

# Baixar o arquivo tar.gz da pasta moodledata
scp root@76.13.227.135:/tmp/backup_moodledata.tar.gz ./
```

### D. Limpeza de Arquivos Temporários na VPS
Sempre apague os arquivos de backup gerados em `/tmp` após concluir o download para evitar o consumo desnecessário de espaço de armazenamento no disco da VPS:
```bash
rm /tmp/backup_moodle_db.sql.gz
rm /tmp/backup_moodledata.tar.gz
```
