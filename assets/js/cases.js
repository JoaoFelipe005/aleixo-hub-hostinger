export function initCases(){
 const buttons=document.querySelectorAll('[data-filter]'),cards=document.querySelectorAll('[data-category]');
 buttons.forEach(button=>button.addEventListener('click',()=>{
 buttons.forEach(b=>b.setAttribute('aria-pressed',String(b===button)));let count=0;
 cards.forEach(card=>{const show=button.dataset.filter==='todos'||card.dataset.category.split(' ').includes(button.dataset.filter);card.hidden=!show;if(show){count++;card.classList.remove('is-pending');card.classList.add('is-visible');}});
 document.querySelector('#filter-status').textContent=`${count} trabalhos encontrados.`;
 }));
}
