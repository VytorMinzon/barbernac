# BarberNac

Sistema web para uma barbearia moderna, com apresentação de serviços, equipe de barbeiros, contato, autenticação e área administrativa para gerenciamento de clientes, funcionários, serviços, depoimentos e agendamentos.

A interface combina **dark mode sofisticado**, tons dourados e uma navegação responsiva. O projeto foi desenvolvido para rodar localmente com XAMPP, PHP e MySQL.

## Funcionalidades

- Página inicial com banner, serviços, equipe, preços e contato.
- Cadastro, edição, listagem e desativação de serviços.
- Upload e exibição de fotos de serviços e funcionários.
- Cadastro e gerenciamento de clientes e funcionários.
- Fluxo de agendamentos.
- Login, logout e recuperação de senha.
- Área administrativa com dashboard.
- Envio de e-mails usando PHPMailer e SMTP.
- Menu responsivo para desktop e dispositivos móveis.
- Fallback para imagens ausentes, evitando imagens quebradas.

## Tecnologias

- **PHP**: lógica da aplicação, controllers, models e views.
- **MySQL**: persistência de usuários, serviços, agendamentos e demais dados.
- **PDO**: conexão e consultas parametrizadas ao banco.
- **HTML5 e CSS3**: estrutura e identidade visual.
- **JavaScript e jQuery**: interações da interface.
- **Bootstrap**: componentes e utilitários responsivos.
- **Swiper**: banners e elementos deslizantes.
- **PHPMailer**: envio de mensagens por SMTP.
- **Apache/XAMPP**: servidor local e módulo de reescrita de URLs.

## Estrutura do projeto

```text
barbernac/
├── app/
│   ├── controllers/       # Regras de entrada e fluxo da aplicação
│   ├── models/            # Consultas e operações no banco
│   └── views/             # Páginas, templates e dashboard
├── config/
│   └── config.php         # Banco, BASE_URL, sessão e SMTP
├── core/
│   ├── Controller.php     # Renderização das views
│   ├── Core.php           # Roteamento principal
│   └── Model.php          # Conexão PDO
├── public/
│   ├── index.php          # Front controller
│   ├── .htaccess          # Reescrita de URLs
│   ├── assets/            # CSS, JavaScript, fontes e imagens
│   ├── uploads/           # Imagens enviadas pelo sistema
│   └── vendors/           # Bibliotecas distribuídas com o projeto
└── tools/                 # Scripts auxiliares de manutenção
```

## Design e interface

A identidade visual usa uma base escura com contraste em dourado e tons neutros. A navbar possui:

- Links principais para Início, Serviços, Barbeiros e Contato.
- Ação de login integrada ao modal existente.
- Menu lateral mobile com overlay e fechamento por clique.
- Estados de hover e foco para teclado.

O footer segue a mesma linguagem visual e organiza informações da barbearia, navegação rápida, horários, contato e redes sociais.

## Requisitos

- Windows com XAMPP.
- Apache ativo.
- MySQL ativo.
- PHP compatível com a versão incluída no XAMPP.
- Extensões PHP PDO MySQL, cURL e GD recomendadas para uploads e imagens.
- Navegador moderno.

## Instalação local

1. Clone ou copie o projeto para o diretório de documentos do Apache:

   ```text
   C:\xampp\htdocs\barbernac
   ```

2. Abra o painel do XAMPP e inicie **Apache** e **MySQL**.

3. Crie um banco chamado `barbernac` no phpMyAdmin.

4. Importe a estrutura e os dados do banco, caso você possua um dump SQL do projeto. Atualmente não há um arquivo `.sql` versionado na raiz deste repositório.

5. Confira a configuração em `config/config.php`:

   ```php
   define('BASE_URL', 'http://localhost/barbernac/public/');
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'barbernac');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

6. Acesse no navegador:

   ```text
   http://localhost/barbernac/public/
   ```

## Banco de dados

O projeto utiliza tabelas com nomes diferentes conforme o domínio. Entre as principais estão:

- `tbl_servico`: serviços, preços, status e `foto_servico`.
- `funcionarios`: funcionários, cargos, status e `foto_funcionario`.
- `clientes`: dados de clientes.
- `tbl_agendamento`: agendamentos.
- `tbl_contato`: mensagens de contato.
- `depoimento`: depoimentos.
- `estado`: estados usados nos cadastros.

As fotos de serviços são salvas no banco no formato:

```text
servico/nome-do-arquivo.ext
```

Fisicamente, ficam em:

```text
public/uploads/servico/
```

As fotos de funcionários usam o mesmo padrão e ficam em:

```text
public/uploads/funcionario/
```

## Uploads e permissões

Os controllers de serviços e funcionários criam os diretórios de upload quando necessário e usam nomes únicos para evitar colisões. As imagens permitidas incluem `jpg`, `jpeg`, `png`, `gif` e `webp`.

Em ambiente local, garanta que o Apache tenha permissão de escrita em:

```text
public/uploads/
```

## Scripts auxiliares

Os scripts de manutenção ficam em `tools/` e devem ser executados pelo terminal, não pelo navegador.

Para visualizar alterações de fotos sem gravar no banco:

```powershell
C:\xampp\php\php.exe tools/atualizar_fotos_servicos.php
```

Para aplicar a atualização:

```powershell
C:\xampp\php\php.exe tools/atualizar_fotos_servicos.php --execute
```

O script verifica se os arquivos existem fisicamente e pode baixar imagens categorizadas para registros ausentes. Faça backup do banco antes de executar rotinas de atualização em dados reais.

## E-mail SMTP

O envio de e-mails é configurado em `config/config.php` e utiliza PHPMailer. Antes de usar essa funcionalidade, configure credenciais SMTP válidas e evite manter senhas reais versionadas no Git.

Para publicar o projeto, mova credenciais para variáveis de ambiente ou outro mecanismo de configuração fora do repositório.

## Rotas principais

Com a configuração padrão:

```text
/                       Página inicial
/home                   Página inicial
/servico                Serviços
/precos                 Preços
/barbeiros              Equipe de barbeiros
/contato                Contato
/auth/login             Login
/dashboard              Dashboard administrativo
```

As rotas são processadas por `public/index.php` e encaminhadas pelo roteador em `core/Core.php`.

## Solução de problemas

### Página não abre

- Confirme se Apache e MySQL estão ativos.
- Verifique se o projeto está em `C:\xampp\htdocs\barbernac`.
- Confirme a URL com `/public/`.
- Verifique se o módulo `mod_rewrite` do Apache está habilitado.

### CSS, JavaScript ou imagens retornam 404

- Confira o valor de `BASE_URL`.
- Confirme se o asset existe dentro de `public/assets/`.
- Verifique se a URL gerada começa com `http://localhost/barbernac/public/`.
- Limpe o cache do navegador com `Ctrl + F5`.

### Foto não aparece

- Confirme o valor de `foto_servico` ou `foto_funcionario` no banco.
- Verifique se o caminho físico correspondente existe em `public/uploads/`.
- Confirme as permissões de leitura do Apache.
- A aplicação usa uma imagem fallback quando o arquivo não é encontrado.

## Segurança antes da publicação

- Troque as credenciais padrão do banco.
- Remova senhas SMTP do código e use variáveis de ambiente.
- Restrinja a execução de scripts da pasta `tools/` ao ambiente CLI.
- Valide tipo, tamanho e conteúdo dos uploads.
- Desative mensagens detalhadas de erro em produção.
- Faça backup do banco antes de atualizações em massa.

## Licença

Este projeto não declara uma licença específica no repositório. Defina uma licença antes de distribuir o código publicamente.
