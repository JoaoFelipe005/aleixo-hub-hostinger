import {initNavigation} from './navigation.js';
import {initScroll} from './scroll.js';
import {initHub} from './hub.js';
import {initCases} from './cases.js';
import {initForm} from './form.js';
initNavigation();initScroll();initHub();initCases();initForm();
const share=document.querySelector('.share-button');
share?.addEventListener('click',async()=>{const status=document.querySelector('.share-status');try{if(navigator.share)await navigator.share({title:document.title,url:location.href});else{await navigator.clipboard.writeText(location.href);status.textContent='Link copiado.';}}catch(error){if(error.name!=='AbortError')status.textContent='Copie o endereço desta página para compartilhar.';}});
