<?php
declare(strict_types=1);
require_once ALEIXO_ROOT.'/app/Contact.php';
function contact_response(int $code,array $data): never {
 http_response_code($code);header('Cache-Control: no-store');
 if(str_contains($_SERVER['HTTP_ACCEPT']??'','application/json')){header('Content-Type: application/json; charset=utf-8');echo json_encode($data,JSON_UNESCAPED_UNICODE);}
 else{header('Content-Type: text/html; charset=utf-8');echo '<!doctype html><html lang="pt-BR"><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Contato — Aleixo Hub</title><link rel="stylesheet" href="/assets/css/main.css"><main class="wrap section"><h1>Contato</h1><p>'.e($data['message']).'</p>';foreach($data['errors']??[] as $message)echo '<p>'.e($message).'</p>';echo '<a class="text-link" href="/contato">Voltar ao contato</a></main></html>';}
 exit;
}
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Allow: POST');contact_response(405,['ok'=>false,'message'=>'Use o formulário para enviar sua mensagem.']);}
if((int)($_SERVER['CONTENT_LENGTH']??0)>20000)contact_response(413,['ok'=>false,'message'=>'A mensagem excede o tamanho permitido.']);
if(!is_string($_POST['csrf']??null)||!hash_equals($_SESSION['csrf']??'',$_POST['csrf'])||empty($_SESSION['csrf']))contact_response(403,['ok'=>false,'message'=>'Sua sessão expirou. Recarregue a página e tente novamente.']);
if(!empty($_POST['website']))contact_response(422,['ok'=>false,'message'=>'Não foi possível validar este envio.']);
$storage=getenv('CONTACT_STORAGE')?:ALEIXO_ROOT.'/storage';
try{if(!Contact::rateLimit($storage,$_SERVER['REMOTE_ADDR']??'unknown')){header('Retry-After: 900');contact_response(429,['ok'=>false,'message'=>'Muitas tentativas. Aguarde alguns minutos e tente novamente.']);}}
catch(Throwable $error){error_log('Contact storage unavailable');contact_response(503,['ok'=>false,'message'=>'O formulário está indisponível. Fale com a Aleixo por telefone ou e-mail.']);}
[$values,$errors]=Contact::validate($_POST);
if($errors)contact_response(422,['ok'=>false,'message'=>'Confira os campos indicados.','errors'=>$errors]);
try{$message=Contact::send($values,$storage);$_SESSION['csrf']=bin2hex(random_bytes(32));contact_response(200,['ok'=>true,'message'=>$message,'token'=>$_SESSION['csrf']]);}
catch(Throwable $error){error_log('Contact delivery failed; no personal data logged.');contact_response(503,['ok'=>false,'message'=>'Não foi possível enviar agora. Tente novamente ou fale com a Aleixo por telefone ou e-mail.']);}
