$('#numWhatsApp').mask('(00) 00000-0000');
$('#numContato').mask('(00) 00000-0000');


ONLY_HTMLELEMENT('#logoFoto').style.display="none";
ONLY_HTMLELEMENT('#bannerAbout').style.display="none";
ONLY_HTMLELEMENT('#bannerContact').style.display="none";

function ocultarPaginas(){
    let paginas=ALL_HTMLELEMENT('.paginaConteudo');
    [...paginas].map((item)=>{
        item.style.display='none';
        item.setAttribute('active','');
    })
}

let inputsMenus=ALL_HTMLELEMENT('#formMenu input');
[...inputsMenus].map((item)=>{
    item.addEventListener('focus',(event)=>{
        let key=parseInt(event.target.getAttribute("key"));
        
        if(key !=2 && key !=3){
            ocultarPaginas();
            
            if(key==1){
                let conteudoHome=ONLY_HTMLELEMENT('.miniSite .conteudoMiniSite .paginaHome');
                conteudoHome.setAttribute('active','active');
                conteudoHome.style.display="flex";
            }
            
            if(key==4){
                let conteudoSobre=ONLY_HTMLELEMENT('.miniSite .conteudoMiniSite .paginaSobre');
                conteudoSobre.setAttribute('active','active');
                conteudoSobre.style.display="flex";
            }

            if(key==5){
                let conteudoContato=ONLY_HTMLELEMENT('.miniSite .conteudoMiniSite .paginaContato');
                conteudoContato.setAttribute('active','active');
                conteudoContato.style.display="flex";
            }
        }
    })
});


ONLY_HTMLELEMENT('.logoEdit').addEventListener('click',(e)=>{
	e.preventDefault();
	$('#logoFoto').trigger('click');

	$('#logoFoto').change(function(e){
   		if($(e.target).val()){
     	 	var img = e.target.files[0];
    	 	var f = new FileReader(); 
   		    f.onload = function(e){ 
         	$(".logoEdit img").attr("src",e.target.result); // altera o src da imagem
      	}
      	f.readAsDataURL(img);
 		}
 	});
});


ONLY_HTMLELEMENT('.bannerAbout').addEventListener('click',(e)=>{
	e.preventDefault();
	$('#bannerAbout').trigger('click');

	$('#bannerAbout').change(function(e){
   		if($(e.target).val()){
     	 	var img = e.target.files[0];
    	 	var f = new FileReader(); 
   		    f.onload = function(e){ 
         	ONLY_HTMLELEMENT('.bannerAbout').style.backgroundImage='url('+e.target.result+')';
      	}
      	f.readAsDataURL(img);
 		}
 	});
});

ONLY_HTMLELEMENT('.bannerContact').addEventListener('click',(e)=>{
	e.preventDefault();
	$('#bannerContact').trigger('click');

	$('#bannerContact').change(function(e){
   		if($(e.target).val()){
     	 	var img = e.target.files[0];
    	 	var f = new FileReader(); 
   		    f.onload = function(e){ 
         	ONLY_HTMLELEMENT('.bannerContact').style.backgroundImage='url('+e.target.result+')';
      	}
      	f.readAsDataURL(img);
 		}
 	});
});


var retorno=true;
$(()=>{
    
    ONLY_HTMLELEMENT('#salvarConfig').addEventListener('click',(event)=>{
        atualizarMenus(event);
    });

    
    function atualizarMenus(event){
        event.preventDefault();
        
        var form=ONLY_HTMLELEMENT('#formMenu');
        var form_data = new FormData(form);
        let corPagina=ONLY_HTMLELEMENT('#corPagina').value;
        form_data.append('corPagina',corPagina);

        var form_url = $('#formMenu').attr("action");
        var form_method = $('#formMenu').attr("method").toUpperCase();
        
            
        $.ajax({
                url: form_url, 
                type: form_method,      
                data: form_data,
                processData:false,
                contentType:false,     
                cache: false,
                async:false,
                success: function(data){      
                    if($.isEmptyObject(data.error)==false){
                        preencherErros(data.error);
                    }else{
                        let conteudoSobre=ONLY_HTMLELEMENT('.miniSite .conteudoMiniSite .paginaSobre');
                        let conteudoContato=ONLY_HTMLELEMENT('.miniSite .conteudoMiniSite .paginaContato');
                        
                        let activeSobre=conteudoSobre.getAttribute('active');
                        let activeContato=conteudoContato.getAttribute('active');
                        

                        if(activeSobre=='active'){
                            atualizarSobre(event);
                        }else if(activeContato=='active'){
                            console.log("ENTROU NESSE IF");
                            atualizarContato(event);
                        }else{
                            location.reload();
                        }
                    }
                }, 
            });
        }    

        function atualizarSobre(event){
            event.preventDefault();
            
            var form=ONLY_HTMLELEMENT('#formSobre');            
            var form_data = new FormData(form);
            var form_url = $('#formSobre').attr("action");
            var form_method = $('#formSobre').attr("method").toUpperCase();
                
                $.ajax({
                    url: form_url, 
                    type: form_method,      
                    data: form_data,
                    processData:false,
                    contentType:false,     
                    cache: false,
                    success: function(data){                          
                        if($.isEmptyObject(data.error)==false){
                            preencherErros(data.error);
                            
                        }else{
                           location.reload();
                        }
                    }            
                });
            }    


            function atualizarContato(event){
                event.preventDefault();
                            
                var form=ONLY_HTMLELEMENT('#formContato');            
                var form_data = new FormData(form);
                var form_url = $('#formContato').attr("action");
                var form_method = $('#formContato').attr("method").toUpperCase();
                
                    $.ajax({
                        url: form_url, 
                        type: form_method,      
                        data: form_data,
                        processData:false,
                        contentType:false,     
                        cache: false,
                        success: function(data){                          
                            if($.isEmptyObject(data.error)==false){
                                preencherErros(data.error);
                                window.scrollTo(0,document.body.scrollHeight);
                            }else{
                                location.reload();
                            }
                        }            
                    });
                } 

        function preencherErros(erros){
            ONLY_HTMLELEMENT('#Alert').style.display="block";
            ONLY_HTMLELEMENT('#Alert ul').innerHTML="";
            erros.map((erro)=>{
                $("#Alert").find("ul").append('<li>'+erro+'</li>');
            })
            
            let alert =document.querySelector("#Alert");
            alert.scrollIntoView();
            
        }    
})
  
tinymce.init({
    selector:'#sobre',
    width:'100%',
    menubar:false,
    plugins:['link', 'table', 'autoresize', 'lists'],
    toolbar:'undo redo | formatselect | bold italic backcolor | '
            +'alignleft alignright aligncenter alignjustify | table |'
            +'link image | bullist numlist | media',
    selector: "textarea",
            
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }        
});


