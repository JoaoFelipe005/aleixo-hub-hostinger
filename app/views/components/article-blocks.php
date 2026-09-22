<?php foreach($blocks as $block): $type=$block['type']??'paragraph'; ?>
<?php if($type==='heading'): ?><h2><?= e($block['text']??'') ?></h2>
<?php elseif($type==='quote'): ?><blockquote><?= e($block['text']??'') ?></blockquote>
<?php elseif($type==='list'): ?><ul><?php foreach($block['items']??[] as $text): ?><li><?= e($text) ?></li><?php endforeach; ?></ul>
<?php elseif($type==='image' && str_starts_with($block['src']??'','/assets/')): ?><figure><?php image_tag($block['src'],$block['alt']??''); ?><?php if(!empty($block['caption'])): ?><figcaption><?= e($block['caption']) ?></figcaption><?php endif; ?></figure>
<?php elseif($type==='gallery'): ?><div class="article-gallery"><?php foreach($block['images']??[] as $image)if(str_starts_with($image['src']??'','/assets/'))image_tag($image['src'],$image['alt']??''); ?></div>
<?php elseif($type==='video' && str_starts_with($block['src']??'','/assets/')): ?><video controls preload="metadata" src="<?= e(asset(substr($block['src'],8))) ?>" aria-label="<?= e($block['alt']??'Vídeo do artigo') ?>"><?php if(!empty($block['captions'])): ?><track kind="captions" src="<?= e(asset(substr($block['captions'],8))) ?>" srclang="pt-BR" label="Português" default><?php endif; ?></video>
<?php else: ?><p><?= e($block['text']??'') ?></p><?php endif; ?>
<?php endforeach; ?>
