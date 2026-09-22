<?php
declare(strict_types=1);
final class Router {
    public static function resolve(string $path,array $cases,array $articles): array {
        $routes=['/'=>['home','A propaganda que vende.','Estratégia, criação, mídia, digital e performance trabalhando como um único sistema.'], '/comunicacao'=>['comunicacao','Comunicação integrada','Estratégia, marca, criação, mídia e produção. Da TV ao clique, uma só campanha.'], '/digital'=>['digital','Aleixo Digital','A evolução da presença digital dentro do ecossistema Aleixo.'], '/turn'=>['turn','Turn Performance','Núcleo de Performance e Inteligência do Aleixo Hub.'], '/trabalhos'=>['trabalhos','Trabalhos','Campanhas e conteúdos da Aleixo para varejo, automotivo e educação.'], '/blog'=>['blog','Blog Aleixo','Comunicação, estratégia, mídia e performance.'], '/sobre'=>['sobre','O Hub','Uma estrutura integrada de comunicação, digital e performance.'], '/contato'=>['contato','Vamos falar da sua marca?','Conte o que sua marca precisa resolver. A conversa começa pelo problema.'], '/politica-de-privacidade'=>['privacidade','Privacidade','Como o Aleixo Hub trata os dados enviados pelo formulário de contato.']];
        if(isset($routes[$path]))return ['view'=>$routes[$path][0],'title'=>$routes[$path][1],'description'=>$routes[$path][2],'status'=>200];
        foreach(['trabalhos'=>$cases,'blog'=>$articles] as $prefix=>$items) if(preg_match('~^/'.$prefix.'/([a-z0-9-]+)$~',$path,$m) && isset($items[$m[1]]))return ['view'=>$prefix==='trabalhos'?'case':'article','title'=>$items[$m[1]]['title'],'description'=>$items[$m[1]]['intro'],'item'=>$items[$m[1]],'status'=>200];
        return ['view'=>'404','title'=>'Página não encontrada','description'=>'Encontre seu caminho pelo Aleixo Hub.','status'=>404];
    }
}
