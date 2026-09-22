<footer class="footer"><div class="wrap">
<div class="footer-top"><p class="eyebrow">O próximo movimento</p><a class="footer-call" href="<?= e(link_url('/contato')) ?>">A boa conversa<br>vem <em>antes.</em> <?= arrow() ?></a></div>
<div class="footer-grid"><div class="footer-brand"><img src="<?= e(asset('img/brand/comunicacao-white.webp')) ?>" width="190" height="70" alt="Aleixo Comunicação"><p>Comunicação. Digital. Performance.<br>Um único ecossistema.</p></div>
<div><p class="eyebrow">Explore o Hub</p><a href="<?= e(link_url('/comunicacao')) ?>">Comunicação</a><a href="<?= e(link_url('/digital')) ?>">Digital</a><a href="<?= e(link_url('/turn')) ?>">Turn Performance</a></div>
<div><p class="eyebrow">Por dentro</p><a href="<?= e(link_url('/trabalhos')) ?>">Trabalhos</a><a href="<?= e(link_url('/blog')) ?>">Blog Aleixo</a><a href="<?= e(link_url('/sobre')) ?>">Sobre o Hub</a><a href="<?= e(link_url('/contato')) ?>">Contato</a></div>
<div><p class="eyebrow">Recife, Pernambuco</p><a href="tel:<?= e(institutional('phone_link')) ?>"><?= e(institutional('phone')) ?></a><a href="mailto:<?= e(institutional('email')) ?>"><?= e(institutional('email')) ?></a><p><?= e(institutional('address')) ?><br><?= e(institutional('city')) ?></p></div></div>
<div class="footer-bottom"><span>© <?= date('Y') ?> Aleixo Hub</span><span>A propaganda que vende.</span><a href="<?= e(link_url('/politica-de-privacidade')) ?>">Privacidade</a></div>
</div></footer>
