ONLY_HTMLELEMENT('#fotoArtigoFile').style.display='none';

ONLY_HTMLELEMENT('#fotoArtigo').addEventListener('click',(e)=>{
	e.preventDefault();
	$('#fotoArtigoFile').trigger('click');

	$('#fotoArtigoFile').change(function(e){
   		if($(e.target).val()){
     	 	var img = e.target.files[0];
    	 	var f = new FileReader(); 
   		    f.onload = function(e){ 
         	$("#fotoArtigo img").attr("src",e.target.result); // altera o src da imagem
      	}
      	f.readAsDataURL(img);
 		}
 	});
});


let excluirArtigo=ALL_HTMLELEMENT('.btnExcluirArtigo');
[...excluirArtigo].map((item)=>{
    item.addEventListener('click',(event)=>{
        event.preventDefault();
        let modal=ONLY_HTMLELEMENT('#modalConfirmacao');
        modal.style.display="block";
        modal.querySelector('.modal-title').innerHTML="Tem Certeza que deseja excluir esse artigo?";
        modal.querySelector('.alert-success').style.display="none";
        modal.querySelector('.alert-danger').style.display="block";
        modal.querySelector('.alert').innerHTML="Todas as informações do artigo serão excluidas!";
        
        modal.querySelector('#confirmarModal').addEventListener('click',(e)=>{
            window.location = item.href; 
        })
    
    })
    
})

let aprovarArtigo=ALL_HTMLELEMENT('.btnAprovarArtigo');
[...aprovarArtigo].map((item)=>{
    item.addEventListener('click',(event)=>{
        event.preventDefault();
        let idArtigo=event.currentTarget.getAttribute('id');
        let modal=ONLY_HTMLELEMENT('#modalConfirmacao');
        modal.style.display="block";
        modal.querySelector('.modal-title').innerHTML="Tem Certeza que deseja aprovar esse artigo?";
        modal.querySelector('.alert-success').style.display="flex";
        modal.querySelector('.alert-danger').style.display="none";
        modal.querySelector('.alert-success').innerHTML="O Artigo se tornará visivel no site!";

        modal.querySelector('#confirmarModal').addEventListener('click',(e)=>{
            
            $.ajax({
                url: rotaStatusArtigo, 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },      
                data: {'aprovado':1,'idArtigo':idArtigo},
                error:(error)=>{
                    alert('algo deu errado'+error);
                }  
            });

            document.location.reload(true);
        })
    
    })
})

let desaprovarArtigo=ALL_HTMLELEMENT('.btnDesaprovarArtigo');
[...desaprovarArtigo].map((item)=>{
    item.addEventListener('click',(event)=>{
        event.preventDefault();
        let idArtigo=event.currentTarget.getAttribute('id');
        let modal=ONLY_HTMLELEMENT('#modalConfirmacao');
        modal.style.display="block";
        modal.querySelector('.modal-title').innerHTML="Tem Certeza que deseja desaprovar esse artigo?";
        modal.querySelector('.alert-success').style.display="none";
        modal.querySelector('.alert-danger').style.display="flex";
        modal.querySelector('.alert-danger').innerHTML="O Artigo sairá do site!";

        modal.querySelector('#confirmarModal').addEventListener('click',(e)=>{
            
            $.ajax({
                url: rotaStatusArtigo, 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },      
                data: {'aprovado':0,'idArtigo':idArtigo},
                error:(error)=>{
                    alert('algo deu errado'+error);
                }  
            });

            document.location.reload(true);
        })
    })
})

    let btnObservacao=ALL_HTMLELEMENT('.btnObservacao');
    [...btnObservacao].map((btnObservacao)=>{
        btnObservacao.addEventListener('click',(event)=>{
        var modal=event.currentTarget.nextElementSibling;
        modal.style.display="block";
        setTimeout(()=>{
            modal.style.opacity=1;
        },500);

        modal.querySelector('.btnObservacaoCancelar').addEventListener('click',(event)=>{
            event.preventDefault();
            setTimeout(()=>{
                modal.style.opacity=0;
            },500);
            modal.style.display="none";
        });
    })
})





ONLY_HTMLELEMENT('.closeModal').addEventListener('click',()=>{
    ONLY_HTMLELEMENT('#modalConfirmacao').style.display="none";
})

ONLY_HTMLELEMENT('#btnNao').addEventListener('click',()=>{
    ONLY_HTMLELEMENT('#modalConfirmacao').style.display="none";
})



ONLY_HTMLELEMENT('#modalConfirmacao').addEventListener('click',(event)=>{
    let ct=event.currentTarget;

    if(event.target==ct){
        ct.style.display="none";
    }
    
})

