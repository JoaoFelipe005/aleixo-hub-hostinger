<div class="wrap breadcrumbs"><a href="<?= e(link_url('/blog')) ?>">Blog Aleixo</a><span>/</span><?= e($item['category']) ?></div>
<?php page_intro($item['category'],e($item['title']),$item['intro']); ?>
<article class="wrap article-body">
<?php if(!empty($item['date'])): ?><p><time datetime="<?= e($item['date']) ?>"><?= e(date('d/m/Y',strtotime($item['date']))) ?></time> · <?= max(1,(int)ceil(preg_match_all('/[\p{L}\p{N}]+/u',json_encode($item['blocks']??$item['sections']??[],JSON_UNESCAPED_UNICODE))/200)) ?> min de leitura</p><?php endif; ?>
<?php if(!empty($item['blocks']))component('article-blocks',['blocks'=>$item['blocks']]);else foreach($item['sections']??[] as [$h,$p]): ?><h2><?= e($h) ?></h2><p><?= e($p) ?></p><?php endforeach; ?>
<?php if(!empty($item['quote'])): ?><blockquote><?= e($item['quote']) ?></blockquote><?php endif; ?>
<?php if(!empty($item['related_cases'])): ?><h2>Trabalhos relacionados</h2><?php foreach($item['related_cases'] as $slug):if(!isset($cases[$slug]))continue; ?><a class="text-link" href="<?= e(link_url('/trabalhos/'.$slug)) ?>"><?= e($cases[$slug]['client']) ?> <?= arrow() ?></a><?php endforeach;endif; ?>
<div><button class="text-link share-button" type="button">Compartilhar artigo <?= arrow() ?></button><p class="share-status" role="status"></p><a class="text-link" href="<?= e(link_url('/blog')) ?>">← Voltar ao blog</a></div>
</article>
