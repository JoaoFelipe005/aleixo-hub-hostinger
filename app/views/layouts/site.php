<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($page['title']) ?> — Aleixo Hub</title><meta name="description" content="<?= e($page['description']) ?>">
<meta name="theme-color" content="#f8f8f4"><meta name="robots" content="<?= ($page['status']===404 || getenv('APP_ENV')!=='production')?'noindex,nofollow':'index,follow' ?>">
<link rel="canonical" href="<?= e(site_url($path)) ?>"><meta property="og:type" content="<?= $page['view']==='article'?'article':'website' ?>"><meta property="og:locale" content="pt_BR"><meta property="og:site_name" content="Aleixo Hub"><meta property="og:title" content="<?= e($page['title']) ?>"><meta property="og:description" content="<?= e($page['description']) ?>"><meta property="og:url" content="<?= e(site_url($path)) ?>"><meta property="og:image" content="<?= e(site_url('/assets/img/brand/comunicacao.webp')) ?>"><meta name="twitter:card" content="summary"><meta name="twitter:title" content="<?= e($page['title']) ?>"><meta name="twitter:description" content="<?= e($page['description']) ?>">
<link rel="icon" href="<?= e(asset('favicon.svg')) ?>" type="image/svg+xml"><link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">

<?php
$schema=['@context'=>'https://schema.org','@type'=>'Organization','name'=>'Aleixo Hub','url'=>site_url('/'),'logo'=>site_url('/assets/img/brand/comunicacao.webp'),'email'=>institutional('email'),'telephone'=>institutional('phone_link')];
?>
<script type="application/ld+json" nonce="<?= e($cspNonce) ?>"><?= json_encode($schema,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP) ?></script>
</head><body class="page-<?= e($page['view']) ?>">

<a href="#main" class="skip-link">Pular para o conteúdo</a><div class="scroll-progress" aria-hidden="true"></div>
<?php component('header',['path'=>$path]); ?>
<main id="main" tabindex="-1"><?php $item=$page['item']??null;require __DIR__.'/../pages/'.$page['view'].'.php'; ?></main>
<?php component('footer'); ?>
<script type="module" src="<?= e(asset('js/main.js')) ?>"></script>

</body></html>
