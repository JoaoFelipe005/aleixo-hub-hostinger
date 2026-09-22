<?php $nav=['/comunicacao'=>'Comunicação','/digital'=>'Digital','/turn'=>'Turn','/trabalhos'=>'Trabalhos','/blog'=>'Blog','/sobre'=>'Sobre']; ?>
<header class="site-header"><div class="wrap header-inner">
<a class="brand" href="<?= e(link_url('/')) ?>" aria-label="Aleixo Hub — início"><img src="<?= e(asset('img/brand/comunicacao.webp')) ?>" width="137" height="50" alt="Aleixo Comunicação"><span>HUB</span></a>
<nav class="desktop-nav" aria-label="Principal"><?php foreach($nav as $href=>$label): ?><a href="<?= e(link_url($href)) ?>" <?= $path===$href?'aria-current="page"':'' ?>><?= e($label) ?></a><?php endforeach; ?></nav>
<a class="header-cta" href="<?= e(link_url('/contato')) ?>">Fale com a gente <?= arrow() ?></a>
<button class="menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="Abrir menu"><span></span><span></span></button>
</div></header>
<dialog class="mobile-menu" id="mobile-menu" aria-label="Menu principal"><button class="menu-close" aria-label="Fechar menu">Fechar ×</button><p class="eyebrow">Aleixo Hub</p><nav><?php foreach($nav+['/contato'=>'Contato'] as $href=>$label): ?><a href="<?= e(link_url($href)) ?>"><?= e($label) ?> <?= arrow() ?></a><?php endforeach; ?></nav><p>Comunicação. Digital. Performance.<br>Uma mesma direção.</p></dialog>
