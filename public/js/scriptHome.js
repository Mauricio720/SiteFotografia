var images=document.querySelector('.areaFotos__fotos');
requisitionAllPictures();
var page=ONLY_HTMLELEMENT('.pagina');
var allImages;
var numFotos=9;


function requisitionAllPictures(){
   fetch(url)
     .then((r)=>r.json())
     .then((json)=>{
         ONLY_HTMLELEMENT('.areaFotos').innerHTML=""; 
         setAllPictures(json,0);
      })
}


function setAllPictures(imagesJson,index) {         
      
      if(window.innerWidth<=480){
         numFotos=4;      
      }
   
      [...imagesJson].map((img,index)=>{
         let image=images.cloneNode(true);
         
         
         if(index<numFotos){
            image.querySelector('img').src=routeImg+"/"+img.caminhoFoto;
         }else{
            image.querySelector('img').setAttribute("data-src",routeImg+"/"+img.caminhoFoto);			
         }
         image.setAttribute('key',img.idFoto);
         image.setAttribute('alt',img.tituloFoto);
         ONLY_HTMLELEMENT('.areaFotos').append(image);
         
        
      })
      
      
      allImages=ALL_HTMLELEMENT('.areaFotos__fotos');
         [...allImages].map((item)=>{
            item.addEventListener('click',(e)=>{
               let id=e.target.closest('.areaFotos__fotos').getAttribute('key');
               let carouselItem=ALL_HTMLELEMENT('#carroselHome .carousel-item');
               
               
               [...carouselItem].map((item)=>{
                  if(item.getAttribute('key')==id){
                     item.classList.add('active');
                  }else{
                     item.classList.remove('active');
                  }
               });
               
               ONLY_HTMLELEMENT('.modalPrincipal').style.display="flex";
               ONLY_HTMLELEMENT('.modalPrincipal').style.opacity=0;

               setTimeout(()=>{
                  ONLY_HTMLELEMENT('.modalPrincipal').style.opacity=1;
               },500);
               
            });
         });
      }  
   
                          
  
function mostrarFoto(){
   let imagens=ALL_HTMLELEMENT('.areaFotos__fotos img');
   imagens.forEach((img,index)=>{
      if(img.getBoundingClientRect().top < window.innerHeight){
         if(index>=numFotos){
            let caminhoFoto=img.getAttribute('data-src');
            img.src=caminhoFoto;
         }
         
      }
   })
}


page.addEventListener('scroll',()=>{
   mostrarFoto();
});

ONLY_HTMLELEMENT('.modalPrincipal').addEventListener('click',(event)=>{
   let ct=event.currentTarget;
   if(event.target==ct){
      ONLY_HTMLELEMENT('.modalPrincipal').style.display="none";
      ONLY_HTMLELEMENT('.modalPrincipal').style.display=0;
    }
})

ONLY_HTMLELEMENT('.fechar--modal').addEventListener('click',(event)=>{
   ONLY_HTMLELEMENT('.modalPrincipal').style.display="none";
   ONLY_HTMLELEMENT('.modalPrincipal').style.display=0;
})






