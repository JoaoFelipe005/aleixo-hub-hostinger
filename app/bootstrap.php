<?php
declare(strict_types=1);
define('ALEIXO_ROOT', dirname(__DIR__));
require_once __DIR__.'/helpers.php';
{
    $env=ALEIXO_ROOT.'/.env';
    if (is_file($env)) foreach(file($env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line),'#') || !str_contains($line,'=')) continue;
        [$key,$value]=explode('=',$line,2); $key=trim($key);
        if (preg_match('/^[A-Z_]+$/',$key) && getenv($key)===false) putenv($key.'='.trim($value," \"'"));
    }
    ini_set('session.use_strict_mode','1');
    session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off','samesite'=>'Lax','path'=>'/']);
    if (session_status()!==PHP_SESSION_ACTIVE) session_start();
    header('X-Content-Type-Options: nosniff'); header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: SAMEORIGIN');
    $cspNonce=base64_encode(random_bytes(16));
    header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; media-src 'self'; script-src 'self' 'nonce-{$cspNonce}'; style-src 'self' 'unsafe-inline'; font-src 'self'; connect-src 'self'; frame-ancestors 'self'; form-action 'self'; base-uri 'self'");
}
$content=json_decode(file_get_contents(__DIR__.'/data/content.json'),true,512,JSON_THROW_ON_ERROR);
$cases=$content['cases']; $articles=array_filter($content['articles'],fn($a)=>$a['status']==='published');
$drafts=$content['articles'];
