ONLY_HTMLELEMENT('#fotoPerfil').style.display="none";
var email=ONLY_HTMLELEMENT('#emailCampo').value;
var codigo;
var emailAtual;

ONLY_HTMLELEMENT('.fotoPerfil').addEventListener('click',(event)=>{
	event.preventDefault();
	$('#fotoPerfil').trigger('click');

	$('#fotoPerfil').change(function(e){
   		if($(e.target).val()){
     	 	var img = e.target.files[0];
    	 	var f = new FileReader(); 
   		    f.onload = function(e){ 
         	$(".fotoPerfil img").attr("src",e.target.result); // altera o src da imagem
      	}
      	f.readAsDataURL(img);
 		}
    });
});

ONLY_HTMLELEMENT('#formPerfil').addEventListener('submit',(event)=>{
    emailAtual=ONLY_HTMLELEMENT('#emailCampo').value;
    if(emailAtual===""){
        ONLY_HTMLELEMENT('#alert').style.display="block";
        ONLY_HTMLELEMENT('#alert').innerHTML="Email em branco!!!";
    
    }else if(email!=emailAtual){
        event.preventDefault();
        ONLY_HTMLELEMENT('#modalConfirmEmail').style.display="block";
        codigo=gerarCodigoConfirmacao();
        
        $.ajax({
            url:urlEmail,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            data:{'codigoEmail':codigo,'email':emailAtual},
           
        });

        ONLY_HTMLELEMENT('#btnSalvar').addEventListener('click',(event)=>{
            let campoCodigo=ONLY_HTMLELEMENT('#campoCodigo').value;
            if(campoCodigo===""){
                ONLY_HTMLELEMENT('#alert').style.display="block";
                ONLY_HTMLELEMENT('#alert').innerHTML="Código em branco!!!";
            }else if(campoCodigo!=codigo){
                ONLY_HTMLELEMENT('#alert').style.display="block";
                ONLY_HTMLELEMENT('#alert').innerHTML="Código incorreto!!!";
            }else{
                
                ONLY_HTMLELEMENT('#emailAlterado').value="true";
                ONLY_HTMLELEMENT('#formPerfil').submit();
            }

        });
    }
})

function gerarCodigoConfirmacao(){
    let parte1=Math.floor(Math.random() * 9999);
    let parte2=Math.floor(Math.random() * 9999);
    let parte3=Math.floor(Math.random() * 99999);
    let parte4=Math.random().toString(36).substring(7);;

    let codigo=parte1+parte2+parte3+parte4;

    return codigo;
}

ONLY_HTMLELEMENT('.close').addEventListener('click',()=>{
    ONLY_HTMLELEMENT('#modalConfirmEmail').style.display="none";
})

ONLY_HTMLELEMENT('#modalConfirmEmail').addEventListener('click',(event)=>{
    let ct=event.currentTarget;

    if(event.target==ct){
        ct.style.display="none";
    }
})
