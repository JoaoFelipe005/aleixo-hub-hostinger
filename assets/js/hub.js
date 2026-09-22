export function initHub(){
 const mq=matchMedia('(prefers-reduced-motion:reduce)'),fine=matchMedia('(pointer:fine)');
 if(mq.matches||!fine.matches)return;
 const hero=document.querySelector('.hero'),territories=[...document.querySelectorAll('.hub-territories>a')];
 hero?.addEventListener('pointermove',e=>{if(mq.matches)return;const box=hero.getBoundingClientRect(),x=(e.clientX-box.left)/box.width-.5;territories.forEach((el,i)=>el.style.transform=`translateX(${x*(i+1)*3}px)`);});
 hero?.addEventListener('pointerleave',()=>territories.forEach(el=>el.style.transform=''));
 document.querySelectorAll('[data-magnetic]').forEach(el=>{el.addEventListener('pointermove',e=>{if(mq.matches)return;const b=el.getBoundingClientRect();el.style.transform=`translate(${(e.clientX-b.left-b.width/2)*.04}px,${(e.clientY-b.top-b.height/2)*.05}px)`;});el.addEventListener('pointerleave',()=>el.style.transform='');});
 mq.addEventListener('change',()=>document.querySelectorAll('[data-magnetic],.hub-territories>a').forEach(el=>el.style.transform=''));
}
