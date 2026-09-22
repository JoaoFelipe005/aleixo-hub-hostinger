export function initForm(){
 const form=document.querySelector('.contact-form');if(!form)return;
 const status=form.querySelector('.form-status'),submit=form.querySelector('[type=submit]'),progress=form.querySelector('progress');
 const clear=()=>{form.querySelectorAll('[aria-invalid]').forEach(el=>el.removeAttribute('aria-invalid'));form.querySelectorAll('.field-error').forEach(el=>el.textContent='');};
 const errors=messages=>{Object.entries(messages).forEach(([name,message])=>{const field=form.elements.namedItem(name),error=form.querySelector(`[data-error="${name}"]`);if(field)field.setAttribute('aria-invalid','true');if(error)error.textContent=message;});form.querySelector('[aria-invalid=true]')?.focus();};
 form.addEventListener('submit',async event=>{
 event.preventDefault();clear();status.textContent='';
 if(!form.checkValidity()){const messages={};[...form.elements].forEach(field=>{if(field.name&&field.validity&&!field.validity.valid)messages[field.name]=field.validity.typeMismatch?'Informe um e-mail válido.':'Preencha este campo para continuar.';});errors(messages);status.textContent='Confira os campos indicados.';return;}
 submit.disabled=true;form.setAttribute('aria-busy','true');progress.hidden=false;status.textContent='Enviando sua mensagem…';
 const controller=new AbortController(),timer=setTimeout(()=>controller.abort(),20000);
 try{const response=await fetch(form.action,{method:'POST',body:new FormData(form),headers:{'Accept':'application/json'},signal:controller.signal});const data=await response.json();status.textContent=data.message;
 if(data.errors)errors(data.errors);
 if(data.token)form.elements.csrf.value=data.token;
 if(data.ok){form.reset();if(data.token)form.elements.csrf.value=data.token;status.focus();}
 }catch{status.textContent='Não foi possível confirmar o envio. Tente novamente ou fale com a Aleixo por telefone.';}
 finally{clearTimeout(timer);submit.disabled=false;form.removeAttribute('aria-busy');progress.hidden=true;}
 });
}
