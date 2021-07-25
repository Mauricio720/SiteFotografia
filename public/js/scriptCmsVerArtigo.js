var fotoArtigo=ONLY_HTMLELEMENT('#fotoArtigo');
if(ONLY_HTMLELEMENT('#fotoArtigoFile') != null){
    ONLY_HTMLELEMENT('#fotoArtigoFile').style.display='none';
}
if(fotoArtigo !=null){
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
}



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


let checkedRevisado=ONLY_HTMLELEMENT('#checkRevisado');
let checkAprovado=ONLY_HTMLELEMENT('#checkAprovado');


if(ONLY_HTMLELEMENT('#observacao')!=null){
    ONLY_HTMLELEMENT('#observacao').disabled=true
}
if(checkedRevisado != null){
    if(checkedRevisado.checked){
        ONLY_HTMLELEMENT('#checkAprovado').disabled=false;
        ONLY_HTMLELEMENT('#observacao').disabled=false;
    }else{
        ONLY_HTMLELEMENT('#checkAprovado').disabled=true;
        ONLY_HTMLELEMENT('#observacao').disabled=true;
    }




checkedRevisado.addEventListener('change',(event)=>{
    if(event.currentTarget.checked){
        ONLY_HTMLELEMENT('#checkAprovado').disabled=false;
        ONLY_HTMLELEMENT('#observacao').disabled=false;
    }else{
        ONLY_HTMLELEMENT('#checkAprovado').disabled=true;
        ONLY_HTMLELEMENT('#observacao').disabled=true;
        ONLY_HTMLELEMENT('#observacao').value="";
    }
})
}

if(checkAprovado != null){
    if(checkAprovado.checked){
        checkedRevisado.disabled=true;
        ONLY_HTMLELEMENT('#observacao').setAttribute('readonly','readonly');
        ONLY_HTMLELEMENT('#observacao').innerHTML="";
    }
}








