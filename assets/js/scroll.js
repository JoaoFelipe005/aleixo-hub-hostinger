import {updateBrand} from './brand-transition.js';
import {initTurn,updateTurn} from './turn.js';
const clamp=n=>Math.min(1,Math.max(0,n));
export function initScroll(){
 const media=matchMedia('(prefers-reduced-motion:reduce)');
 const header=document.querySelector('.site-header'),bar=document.querySelector('.scroll-progress');
 const scenes=[...document.querySelectorAll('[data-scene]')];let bounds=[],scheduled=false;
 const measure=()=>{bounds=scenes.map(el=>({el,top:el.getBoundingClientRect().top+scrollY,height:el.offsetHeight,stage:el.querySelector('.channel-stage')?.clientWidth||0}));};
 const paint=()=>{scheduled=false;const y=scrollY,h=innerHeight,reduced=media.matches;
  header?.classList.toggle('scrolled',y>24);bar?.style.setProperty('transform',`scaleX(${clamp(y/(document.documentElement.scrollHeight-h||1))})`);
  bounds.forEach(({el,top,height,stage})=>{
   if(y+h<top||y>top+height)return;
   const p=reduced?1:clamp((y-top+76)/Math.max(height-h+76,1));
   if(el.dataset.scene==='channels'){
    el.style.setProperty('--progress',p);
    el.querySelectorAll('.channel-node').forEach((node,i)=>{node.style.left='50%';node.style.top='50%';const a=(i/10)*Math.PI*2-Math.PI/2;const radius=stage*(innerWidth<701?.385:.4);const targetX=Math.cos(a)*radius,targetY=Math.sin(a)*radius;const spreadX=((i%3)-1)*stage*.2,spreadY=(i%2?1:-1)*stage*.13;const eased=1-Math.pow(1-p,3);node.style.transform=`translate(-50%,-50%) translate(${targetX+spreadX*(1-eased)}px,${targetY+spreadY*(1-eased)}px)`;});
   }
   if(el.dataset.scene==='digital')updateBrand(el,p,reduced);
   if(el.dataset.scene==='turn')updateTurn(el,clamp((y+h-top)/(height+h*.2)),reduced);
   if(el.dataset.scene==='pipeline')el.querySelectorAll('[data-step]').forEach((node,i)=>node.classList.toggle('is-active',reduced||i<=Math.floor(p*11)));
  });
 };
 const schedule=()=>{if(!scheduled){scheduled=true;requestAnimationFrame(paint);}};
 const refresh=()=>{measure();schedule();};
 addEventListener('scroll',schedule,{passive:true});addEventListener('resize',refresh,{passive:true});addEventListener('load',refresh);media.addEventListener('change',refresh);
 new ResizeObserver(refresh).observe(document.body);
 const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('is-visible');entry.target.classList.remove('is-pending');observer.unobserve(entry.target);}}),{threshold:.06});
 document.querySelectorAll('.reveal').forEach(el=>{if(!media.matches&&el.getBoundingClientRect().top>innerHeight)el.classList.add('is-pending');observer.observe(el);});
 initTurn();refresh();
}
