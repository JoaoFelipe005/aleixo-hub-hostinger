# Publicar o Aleixo Hub na Hostinger

Este pacote é PHP standalone. Não usa WordPress, Node em produção ou banco de dados.

1. Faça backup do conteúdo atual do destino. No hPanel, selecione PHP 8.2 ou superior e confira as extensões `mbstring`, `openssl`, `fileinfo` e `session`.
2. Abra o Gerenciador de Arquivos e entre em `public_html` (ou na pasta de destino do domínio).
3. Envie `aleixo-hub-hostinger.zip` e extraia **o conteúdo** nessa pasta. `index.php`, `.htaccess`, `assets`, `app` e `vendor` devem ficar no mesmo nível.
4. Copie `.env.example` para `.env`. Ajuste `APP_URL=https://seu-dominio.com.br` sem barra final e `APP_ENV=production`.
5. Para uma subpasta, por exemplo `public_html/hub`, use `APP_URL=https://seu-dominio.com.br/hub`. URLs de navegação e assets usam esse prefixo automaticamente.
6. Configure SMTP: `MAIL_TRANSPORT=smtp`, `MAIL_FROM`, `MAIL_TO`, `SMTP_HOST`, `SMTP_PORT`, `SMTP_ENCRYPTION`, `SMTP_USERNAME`, `SMTP_PASSWORD`. Use os dados exibidos no painel do seu provedor de e-mail. Porta 587 usa `tls`; porta 465 usa `ssl`. Não coloque as credenciais em arquivos públicos nem no Git.
7. Garanta que `storage` seja gravável pelo PHP. Prefira 0700 ou 0750 conforme o usuário do servidor; nunca 0777.
8. Ative HTTPS no domínio. Abra `/contato`, envie uma mensagem sua e confirme recebimento na caixa de destino. Abra `/trabalhos/honda`, `/digital`, `/turn`, `/blog`, `/sitemap.xml` e `/robots.txt`.
9. Confira que `/.env`, `/app/data/content.json`, `/storage/` e `/vendor/` retornam 403/404. A proteção depende de o servidor aplicar o `.htaccess` fornecido; não hospede esse pacote de raiz em um servidor que ignore essas regras.
10. Remova o ZIP do servidor depois de extrair. O site não foi publicado pelo agente.

## O que já vem pronto

PHPMailer e autoload estão incluídos. Não é necessário rodar Composer no servidor. O formulário tem validação server-side, token CSRF, honeypot, limite de 5 tentativas a cada 15 minutos por IP e erros acessíveis. Nunca informa sucesso se o SMTP falhar.

`MAIL_TRANSPORT=log` funciona somente fora de produção, para testes. Registra arquivos privados em `storage`; não envia e-mail. `MAIL_TRANSPORT=disabled` deixa o contato por telefone/e-mail disponível e retorna erro honesto ao tentar enviar o formulário.

`robots.txt` e `sitemap.xml` são gerados por PHP. Em `APP_ENV=local`, o site usa noindex e bloqueia rastreamento. Em produção, sitemap e canonical usam APP_URL.

## Editar conteúdo

- `app/data/content.json`: cases e artigos. Artigos com `status: draft` não são publicados. Altere para `published` apenas depois da validação editorial.
- `app/data/institutional.json`: telefone, e-mail e endereço.
- `app/views/`: componentes e páginas.
- `assets/css/tokens.css`: cores, espaçamentos e tipografia.
- `assets/js/`: interações por responsabilidade.

O blog foi preparado com os quatro rascunhos encontrados no HTML original. Não há datas ou resultados inventados. O escopo detalhado de Aleixo Digital deve ser validado antes de ampliar sua página. A política de privacidade descreve a configuração entregue; revise se adicionar analytics, publicidade ou novos fornecedores.

## Se algo não abrir

- 404 nas páginas internas: confira `.htaccess` e o destino da extração.
- Sem CSS/imagens: confira APP_URL, principalmente o caminho de subpasta.
- Erro 500: confira versão/extensões de PHP e o log de erros da hospedagem. Nunca ative exibição pública de erros com credenciais em produção.
- Formulário falha: confira SMTP, remetente autorizado e permissão da pasta privada storage.
