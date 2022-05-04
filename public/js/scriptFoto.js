ONLY_HTMLELEMENT('#fotosFile').style.display='none';
ONLY_HTMLELEMENT('#enviarFotos').disabled=true;

ONLY_HTMLELEMENT('#addFoto').addEventListener('click',(event)=>{
    ONLY_HTMLELEMENT('#Modal').style.display="flex";
})

var fotoSelecionada=ONLY_HTMLELEMENT('.fotoSelecionada');
var areaListaFoto=ONLY_HTMLELEMENT('.containerListaFotos');
var change=0;

ONLY_HTMLELEMENT('#escolherFoto').addEventListener('click',(e)=>{
	e.preventDefault();
	$('#fotosFile').trigger('click');
});


let excluirFoto=ALL_HTMLELEMENT('.excluirFotoBtn');
[...excluirFoto].map((item)=>{
	item.addEventListener('click',(event)=>{
		event.preventDefault();
        let modal=ONLY_HTMLELEMENT('#modalConfirmacao');
        modal.style.display="flex";
        modal.querySelector('.modal-title').innerHTML="Tem Certeza que deseja excluir essa foto?";
        
        modal.querySelector('#confirmarModal').addEventListener('click',(e)=>{
            window.location = item.href; 
        })
    })
})


ONLY_HTMLELEMENT('#fotosFile').addEventListener('change',(e)=>{
	ONLY_HTMLELEMENT('.areaListaFotos').style.justifyContent='flex-start';
	var tamanho=0;
	if(e.currentTarget.files){
		fotoSelecionada.style.display='flex';
		areaListaFoto.innerHTML='';   
		let imagens= e.target.files;
		
		[...imagens].map((foto)=>{
			tamanho=tamanho+foto.size;
			var fileReader = new FileReader(); 
			fileReader.onload = (e)=>{ 
				 fotoSelecionada=fotoSelecionada.cloneNode(true);
				 fotoSelecionada.querySelector('img').src=e.currentTarget.result;
				 areaListaFoto.append(fotoSelecionada);
			}
			fileReader.readAsDataURL(foto);
		})
	 }

	 ONLY_HTMLELEMENT('#enviarFotos').disabled=false;

	 if(tamanho > 60885114){
		ONLY_HTMLELEMENT('#alertLimit').style.display='block';
		areaListaFoto.innerHTML='';
		ONLY_HTMLELEMENT('#fotosFile').value="";
		ONLY_HTMLELEMENT('#enviarFotos').disabled=true;
	 }
	 
	
});

ONLY_HTMLELEMENT('#Modal').addEventListener('click',(event)=>{
	let ct=event.currentTarget;
	if(event.target==ct){
	   ONLY_HTMLELEMENT('#Modal').style.display="none";
	   areaListaFoto.innerHTML='';
	   ONLY_HTMLELEMENT('#fotosFile').value="";
	   ONLY_HTMLELEMENT('.areaListaFotos').style.justifyContent='center';

	   let h4=document.createElement('h4');
	   h4.innerHTML="Nenhuma foto selecionada";  
	   areaListaFoto.appendChild(h4);
	   ONLY_HTMLELEMENT('#alertLimit').style.display='none';
	   ONLY_HTMLELEMENT('#enviarFotos').disabled=true;

	 }
 })
 
 ONLY_HTMLELEMENT('#closeAreaFotos').addEventListener('click',()=>{
    ONLY_HTMLELEMENT('#Modal').style.display="none";
	   areaListaFoto.innerHTML='';
	   ONLY_HTMLELEMENT('#fotosFile').value="";
	   ONLY_HTMLELEMENT('.areaListaFotos').style.justifyContent='center';
	   let h4=document.createElement('h4');
	   h4.innerHTML="Nenhuma foto selecionada";  
	   areaListaFoto.appendChild(h4);
	   ONLY_HTMLELEMENT('#alertLimit').style.display='none';
	   ONLY_HTMLELEMENT('#enviarFotos').disabled=true;
})


 ONLY_HTMLELEMENT('.closeConfirmacao').addEventListener('click',()=>{
    ONLY_HTMLELEMENT('#modalConfirmacao').style.display="none";
})

ONLY_HTMLELEMENT('#btnNao').addEventListener('click',()=>{
    ONLY_HTMLELEMENT('#modalConfirmacao').style.display="none";
})




