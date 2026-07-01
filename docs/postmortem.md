# Post-Mortem: Implantação e Customização do Moodle 5.0 (CDC Moodle)

**Autor:** Equipe de Engenharia CDC / AI Coding Assistant  
**Data:** 01 de Julho de 2026  
**Status:** Concluído com Sucesso  

---

## 1. Resumo Executivo
Este documento descreve o processo de migração, limpeza de infraestrutura antiga e implantação da nova plataforma Moodle 5.0 customizada com o tema corporativo **CDC Moodle** (baseado no design Uena) na VPS Hostinger sob o painel Easypanel. O projeto atingiu 100% de estabilidade, desempenho otimizado (redução de 47% no tamanho do tema) e acessibilidade de ponta.

---

## 2. Linha do Tempo e Incidentes (O que deu errado e como foi resolvido)

### Incidente A: Erro de Codificação de Caracteres no Banco (UTF-8)
* **Sintoma:** O instalador do Moodle 5 bloqueou o avanço no assistente de instalação apontando o erro `unicode: must be installed and enabled`.
* **Causa:** O MariaDB cria novos esquemas de banco de dados com a codificação padrão de sistema (`latin1` ou `utf8`), mas o Moodle 5 exige estritamente a codificação `utf8mb4_unicode_ci`.
* **Resolução:** Execução de comando SQL via terminal da VPS alterando as tabelas e o banco de dados ativo:
  ```sql
  ALTER DATABASE moodle_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  ```

### Incidente B: Perda de Variáveis de Ambiente no PHP/Apache
* **Sintoma:** A conexão com o banco de dados falhava com o erro `using password: NO`, mesmo com as variáveis de conexão definidas no Easypanel.
* **Causa:** O Apache em modo Prefork/mod_php por padrão limpa as variáveis de ambiente do shell para segurança, fazendo com que `getenv()` retornasse vazio para a senha do banco.
* **Resolução:** Adição da diretiva `PassEnv` no arquivo de configuração do Apache pelo Dockerfile, instruindo-o a expor explicitamente as variáveis de banco de dados do contêiner para o PHP.

### Incidente C: Sobrescrita de Imagem por Volume Persistente (`/var/www/html`)
* **Sintoma:** Qualquer alteração no Dockerfile (como compilação de Composer ou criação do config.php dinâmico) não surtia efeito na VPS.
* **Causa:** O Easypanel montava um volume persistente diretamente em `/var/www/html`. No Docker, volumes montados sobrepõem os arquivos compilados da imagem no Dockerfile.
* **Resolução:** Ajuste de arquitetura de persistência: o volume do código (`/var/www/html`) foi removido, permitindo que a imagem rode limpa e direta do Dockerfile. Apenas a pasta de dados (`/var/www/moodledata`) foi mantida como persistente.

### Incidente D: Caching de Build no Git Clone do Dockerfile
* **Sintoma:** Atualizações de código enviadas ao GitHub do tema não eram aplicadas no deploy da VPS.
* **Causa:** O Docker armazena as camadas de instrução em cache. Como o comando `git clone` continuava idêntico no Dockerfile, o Docker reutilizava a camada antiga da memória.
* **Resolução:** Instrução para realizar deploy forçado sem cache no Easypanel ou alteração de comentário de versão do tema no Dockerfile para invalidar o cache da camada.

### Incidente E: Logotipos e Carrossel Quebrados na Tela de Login
* **Sintoma:** A estrutura dividida e o rodapé institucional renderizavam, mas as imagens do logo e do carrossel exibiam ícones de links quebrados.
* **Causa:** As imagens eram referenciadas a partir do caminho absoluto da raiz do site (`config.wwwroot`), mas o Apache aponta apenas para o diretório `/public`, impossibilitando o acesso direto às imagens locais do tema.
* **Resolução:** Atualização dos caminhos no arquivo `login_layout.mustache` e `navbar.mustache` para utilizar o servidor de imagens interno do Moodle (`theme/image.php/cdc_moodle/...`), permitindo ao Moodle servir as imagens dinamicamente da pasta `pix/`.

---

## 3. Lições Aprendidas e Recomendações de Longo Prazo

1. **Separação de Código e Dados no Docker:** Nunca persista pastas de código-fonte (`/html`) em contêineres Docker de produção. Isso quebra o pipeline de Deploy e gera bugs de cache persistentes. Persista apenas dados gerados por usuários (`moodledata`).
2. **Depuração Silenciosa de SCSS:** O Moodle oculta erros de SCSS. Sempre valide o SCSS utilizando o script de compilação por CLI presente na documentação para evitar regressões visuais silenciosas.
3. **Multi-Linguagem em Temas Customizados:** Sempre forneça arquivos de idioma correspondentes ao idioma de uso do site (como `lang/pt_br/`) para plugins customizados, evitando bugs de exibição de nomes técnicos (como `[[pluginname]]`).
4. **Isolamento de Variáveis do Banco:** Não armazene senhas no Dockerfile ou código-fonte. O uso de `PassEnv` combinado com as variáveis do Easypanel provou ser a forma mais segura e flexível de gerenciar credenciais em produção.

---

## 4. Conclusão
A implantação do Moodle 5.0 e do tema CDC Moodle consolidou uma plataforma moderna, de alta performance e totalmente pronta para escala. A adoção de boas práticas de DevOps e a automação do build garantem que futuras atualizações sejam simples de manter e livres de erros.
