export function initNavigation(){
 const dialog=document.querySelector('#mobile-menu'),toggle=document.querySelector('.menu-toggle');
 if(!dialog||!toggle)return;
 const close=()=>dialog.close();
 toggle.addEventListener('click',()=>{dialog.showModal();toggle.setAttribute('aria-expanded','true');document.body.classList.add('menu-open');});
 dialog.querySelector('.menu-close').addEventListener('click',close);
 dialog.addEventListener('close',()=>{toggle.setAttribute('aria-expanded','false');document.body.classList.remove('menu-open');toggle.focus();});
 dialog.querySelectorAll('a').forEach(a=>a.addEventListener('click',close));
 matchMedia('(min-width:1001px)').addEventListener('change',e=>{if(e.matches&&dialog.open)close();});
}
