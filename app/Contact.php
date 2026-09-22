<?php
declare(strict_types=1);
final class Contact {
 public const NEEDS=['Comunicação','Campanha','Marca','Conteúdo','Mídia','Digital','Performance','Ainda não sei'];
 public static function validate(array $input): array {
  $values=[];$errors=[];
  foreach(['name'=>120,'company'=>120,'email'=>254,'phone'=>120,'message'=>5000,'need'=>100] as $key=>$limit){
   $raw=$input[$key]??'';
   if(!is_string($raw)){$errors[$key]='Valor inválido.';$raw='';}
   $value=trim(strip_tags($raw));
   if(mb_strlen($value)>$limit)$errors[$key]='Este campo excede o limite de caracteres.';
   $values[$key]=$value;
  }
  if($values['name']==='')$errors['name']='Informe seu nome.';
  if(!filter_var($values['email'],FILTER_VALIDATE_EMAIL)||preg_match('/[\r\n]/',$values['email']))$errors['email']='Informe um e-mail válido.';
  if($values['message']==='')$errors['message']='Conte um pouco do contexto.';
  if(!in_array($values['need'],self::NEEDS,true))$errors['need']='Escolha uma das opções.';
  return [$values,$errors];
 }
 public static function rateLimit(string $dir,string $identity): bool {
  if(!is_dir($dir)&&!mkdir($dir,0700,true)&&!is_dir($dir))throw new RuntimeException('storage unavailable');
  $fp=fopen($dir.'/rate-'.hash('sha256',$identity).'.json','c+');if(!$fp)throw new RuntimeException('rate storage unavailable');
  try{if(!flock($fp,LOCK_EX))throw new RuntimeException('rate lock unavailable');$history=json_decode(stream_get_contents($fp)?:'[]',true)?:[];$history=array_values(array_filter($history,fn($t)=>is_int($t)&&$t>time()-900));$ok=count($history)<5;if($ok)$history[]=time();ftruncate($fp,0);rewind($fp);fwrite($fp,json_encode($history));flock($fp,LOCK_UN);return $ok;}finally{fclose($fp);}
 }
 public static function body(array $v): string {return "Interesse: {$v['need']}\nNome: {$v['name']}\nEmpresa: {$v['company']}\nE-mail: {$v['email']}\nTelefone: {$v['phone']}\n\n{$v['message']}";}
 public static function send(array $values,string $storage): string {
  $transport=getenv('MAIL_TRANSPORT')?:'disabled';
  if($transport==='log'&&getenv('APP_ENV')!=='production'){
   if(!is_dir($storage))mkdir($storage,0700,true);
   $filename=$storage.'/contact-'.bin2hex(random_bytes(16)).'.json';
   if(file_put_contents($filename,json_encode(['received'=>gmdate('c'),'test'=>true,'data'=>$values],JSON_UNESCAPED_UNICODE),LOCK_EX)===false)throw new RuntimeException('write failed');chmod($filename,0600);
   return 'Mensagem registrada no ambiente local de teste. Nenhum e-mail foi enviado.';
  }
  if($transport!=='smtp')throw new RuntimeException('mail unconfigured');
  $autoload=ALEIXO_ROOT.'/vendor/autoload.php';if(!is_file($autoload))throw new RuntimeException('mail dependency absent');require_once $autoload;
  $mail=new PHPMailer\PHPMailer\PHPMailer(true);$mail->isSMTP();$mail->Host=getenv('SMTP_HOST')?:'';$mail->Port=(int)(getenv('SMTP_PORT')?:587);
  $encryption=getenv('SMTP_ENCRYPTION')?:'tls';if(!in_array($encryption,['tls','ssl'],true))throw new RuntimeException('encryption required');$mail->SMTPSecure=$encryption;
  $mail->SMTPAuth=(bool)getenv('SMTP_USERNAME');$mail->Username=getenv('SMTP_USERNAME')?:'';$mail->Password=getenv('SMTP_PASSWORD')?:'';$mail->Timeout=15;$mail->CharSet='UTF-8';
  $mail->setFrom(getenv('MAIL_FROM')?:'', 'Aleixo Hub');$mail->addAddress(getenv('MAIL_TO')?:'');$mail->addReplyTo($values['email']);$mail->Subject='Contato pelo site — '.$values['need'];$mail->Body=self::body($values);$mail->send();return 'Mensagem enviada. Obrigado por conversar com a Aleixo.';
 }
}
