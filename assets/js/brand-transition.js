export function updateBrand(scene,progress,reduced){
 const morph=scene.querySelector('.brand-morph');if(morph)morph.style.setProperty('--morph',reduced?1:progress);
}
