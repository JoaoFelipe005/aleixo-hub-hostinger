<?php
declare(strict_types=1);
require __DIR__.'/app/bootstrap.php';
require ALEIXO_ROOT.'/app/Router.php';
$path=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) ?: '/';
$base=base_path();
if($base!=='' && ($path===$base || str_starts_with($path,$base.'/')))$path=substr($path,strlen($base)) ?: '/';
if($path!=='/')$path=rtrim($path,'/');
if($path==='/api/contact') {require ALEIXO_ROOT.'/app/controllers/contact.php';exit;}
if($path==='/robots.txt') {header('Content-Type: text/plain');echo (getenv('APP_ENV')==='production'?"User-agent: *\nAllow: /\nSitemap: ".site_url('/sitemap.xml'):"User-agent: *\nDisallow: /");exit;}
if($path==='/sitemap.xml') {
 header('Content-Type: application/xml; charset=utf-8'); echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
 $paths=['/','/comunicacao','/digital','/turn','/trabalhos','/blog','/sobre','/contato','/politica-de-privacidade'];
 foreach($cases as $s=>$c)$paths[]='/trabalhos/'.$s;foreach($articles as $s=>$a)$paths[]='/blog/'.$s;
 foreach($paths as $p)echo '<url><loc>'.e(site_url($p)).'</loc></url>';echo '</urlset>';exit;
}
$page=Router::resolve($path,$cases,$articles);http_response_code($page['status']);
require ALEIXO_ROOT.'/app/views/layouts/site.php';
