# Painel de Personalização de Aparência do Moodle

Integramos com sucesso o recurso **"Personalizar Aparência"** na aba do Widget de Acessibilidade Flutuante. O Moodle agora permite customização visual em tempo real e de forma persistente.

---

## O que foi construído:

### 1. Novo Layout de Abas no Widget (`footer.mustache`)
Dividimos o painel suspenso do widget em duas abas usando Bootstrap 5 nativo:
- **Aba "Acessibilidade":** Controles anteriores (Aumento/Diminuição de fonte, Escala de cinza, Alto contraste e Temas claro/escuro).
- **Aba "Aparência":** Novos controles interativos para o usuário:
  - **Fonte do Texto (Menu Dropdown):** Permite alterar a família de fontes globais entre:
    1. *Padrão do Tema*
    2. *OpenDyslexic* (fonte especial importada via CDN projetada para dislexia)
    3. *Serifada* (Georgia/Times para leitura confortável de artigos e textos longos)
    4. *Monospace* (para leitura estruturada e espaçada)
  - **Cor do Tema (Paletas Circulares):** Círculos coloridos para trocar a cor de destaque (marca) do Moodle em tempo real para:
    - 🟠 Laranja CDC (`#F6A02A` - padrão)
    - 🔵 Azul Corporativo (`#0D6EFD`)
    - 🟢 Verde Cidadania (`#198754`)
    - 🟣 Roxo Educação (`#6F42C1`)
  - **Cabeçalho de Navegação (Botões de Ação):** Altera o estilo do menu superior para:
    - *Claro:* Fundo branco e fontes escuras.
    - *Escuro:* Fundo escuro e fontes brancas.
    - *Tema:* Fundo pintado com a cor do tema selecionada (Laranja, Azul, Verde ou Roxo).
- **Restaurar Padrão:** O botão de reset foi posicionado de forma compartilhada na base das abas para restaurar tanto a acessibilidade quanto o estilo padrão de uma só vez.

### 2. Controle e Persistência JavaScript (`accessibility.js`)
O script do widget controla todas as transições instantaneamente, **sem necessidade de atualizar a página**:
- **Variáveis CSS Dinâmicas:** Ao mudar uma opção de cor, fonte ou cabeçalho, o script injeta a nova configuração no `:root` do documento (ex: `document.documentElement.style.setProperty('--theme-primary', novaCor)`).
- **Sincronização com o localStorage:** Salva e lê as preferências do mesmo objeto `uena_accessibility_settings` persistido no navegador do usuário, garantindo que as mudanças reflitam em todas as páginas visitadas.

### 3. Estilização Global em Tempo Real (`lib.php`)
Adicionamos suporte a variáveis CSS nativas em toda a casca do tema Moodle, aplicando-as nos botões primários (`.btn-primary`), no cabeçalho superior (`.navbar` e `header`), em links de texto, botões de ação e campos de login.

---

## Como Testar:
1. Abra uma aba anônima e acesse **`http://localhost/`** (ou dê um **Ctrl + F5**).
2. Clique no ícone de acessibilidade (flutuando no canto inferior direito, logo acima da interrogação).
3. Vá para a nova aba **"Aparência"**.
4. Selecione uma fonte (ex: *OpenDyslexic* ou *Serifada*), clique em uma cor (ex: *Azul* ou *Verde*) e escolha um estilo de cabeçalho (ex: *Tema* ou *Escuro*).
5. Veja a interface do Moodle mudar de cor e tipografia em milissegundos!
6. Navegue por páginas de cursos ou recarregue a página — as configurações visuais selecionadas permanecem ativas graças ao salvamento seguro no `localStorage`.
7. Clique em **"Restaurar Padrão"** na base do menu para retornar instantaneamente à identidade visual padrão do CDC.
