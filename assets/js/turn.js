export function initTurn(){
 document.querySelectorAll('.turn-section').forEach(section=>{
 const button=section.querySelector('.turn-switch');
 button?.addEventListener('click',()=>{const active=button.getAttribute('aria-pressed')!=='true';button.setAttribute('aria-pressed',String(active));section.dataset.manual=String(active);section.classList.toggle('turn-on',active);section.style.setProperty('--turn',active?1:0);});
 });
}
export function updateTurn(scene,progress,reduced){
 if(scene.dataset.manual!==undefined)return;
 const active=reduced||progress>.45;scene.style.setProperty('--turn',Math.min(1,progress*1.5));scene.classList.toggle('turn-on',active);scene.querySelector('.turn-switch')?.setAttribute('aria-pressed',String(active));
}
