<?php
declare(strict_types=1);
function e(mixed $v): string { return htmlspecialchars((string)$v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function site_url(string $path='/'): string {
    return rtrim(getenv('APP_URL') ?: 'http://127.0.0.1:8080','/').$path;
}
function base_path(): string { return rtrim(parse_url(getenv('APP_URL') ?: '', PHP_URL_PATH) ?: '', '/'); }
function link_url(string $path='/'): string { return base_path().$path; }
function asset(string $path): string { return link_url('/assets/'.ltrim($path,'/')); }
function component(string $name,array $vars=[]): void { extract($vars,EXTR_SKIP); require __DIR__.'/views/components/'.$name.'.php'; }
function image_tag(string $src,string $alt,string $class='',bool $eager=false): void {
    $key=preg_replace('~^/assets/img/|\.webp$~','',$src);
    static $meta=null; $meta ??= json_decode(file_get_contents(__DIR__.'/data/images.json'),true);
    $m=$meta[$key]??['width'=>1200,'height'=>800,'sizes'=>[]];
    $base=asset('img/'.$key);$set=[];
    foreach($m['sizes'] as $w) $set[]=$base.'-'.$w.'.webp '.$w.'w';
    $set[]=$base.'.webp '.$m['width'].'w';
    echo '<img src="'.e($base.'.webp').'" srcset="'.e(implode(', ',$set)).'" sizes="(max-width: 700px) 100vw, 66vw" width="'.$m['width'].'" height="'.$m['height'].'" alt="'.e($alt).'" class="'.e($class).'" loading="'.($eager?'eager':'lazy').'" decoding="async"'.($eager?' fetchpriority="high"':'').'>';
}
function arrow(): string { return '<span aria-hidden="true" class="arrow">↗</span>'; }
function csrf_token(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function page_intro(string $eyebrow,string $title,string $description='',string $class=''): void { component('page-intro',compact('eyebrow','title','description','class')); }

function institutional(string $key): mixed { static $config=null; $config ??= json_decode(file_get_contents(__DIR__.'/data/institutional.json'),true);return $config[$key]??''; }
