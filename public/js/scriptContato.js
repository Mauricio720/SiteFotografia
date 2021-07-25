
$('input[name=nome]').keyup((event)=> { 
    event.target.value = event.target.value.replace(/[^a-zA-Z.áàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]/g,'');
});

jQuery(function($){
    $("input[name=telefone]").mask("(99)99999-9999",{completed:function(){
        $("input[name=telefone]").val="";
     }});
 });


ONLY_HTMLELEMENT('.formContact').addEventListener('submit',(event)=>{
    let inputNome=ONLY_HTMLELEMENT('input[name=nome]').value;
    let inputEmail=ONLY_HTMLELEMENT('input[name=email]').value;
    let inputTelefone=ONLY_HTMLELEMENT('input[name=telefone]').value;
    let inputDataEvento=ONLY_HTMLELEMENT('input[name=dataEvento]').value;
    let descricaoEvento=ONLY_HTMLELEMENT('textarea[name=descricaoEvento]').value.trim();

    
    if(inputNome==="" || descricaoEvento==="" || inputEmail===""
         || inputTelefone==="" || inputDataEvento===""){
        
        event.preventDefault();    
        ONLY_HTMLELEMENT('#Alert').style.display="block";
        ONLY_HTMLELEMENT('#Alert').innerHTML="Preencha os campos obrigatorios";
    }
})

if(modalAtivo===true){
    desabilitarInputsModal();
}


function desabilitarInputsModal(){
    let inputsModais=ALL_HTMLELEMENT('#formContatoModal input');
    [...inputsModais].map((input)=>{
        input.setAttribute('readonly','readonly');
    });
    ONLY_HTMLELEMENT('#confirmar').disabled=false;
}


function habilitarInputsModal(){
    let inputsModais=ALL_HTMLELEMENT('#formContatoModal input');
    [...inputsModais].map((input)=>{
        input.readOnly = false;
    })
}

if(modalAtivo===true){
    ONLY_HTMLELEMENT('#Editar').addEventListener('click',(event)=>{
        event.preventDefault();
        habilitarInputsModal();
    })

    

    ONLY_HTMLELEMENT('.modalContato').addEventListener('click',(event)=>{
        let ct=event.currentTarget;
        if(event.target==ct){
        ONLY_HTMLELEMENT('.modalContato').style.display="none";
        ONLY_HTMLELEMENT('.modalContato').style.display=0;
        }
    })

    ONLY_HTMLELEMENT('.fechar--modal').addEventListener('click',(event)=>{
        let ct=event.currentTarget;
        ONLY_HTMLELEMENT('.modalContato').style.display="none";
        ONLY_HTMLELEMENT('.modalContato').style.display=0;
        
    })
} 

ONLY_HTMLELEMENT('.pagina').addEventListener('scroll',(event)=>{
    const parallax=ONLY_HTMLELEMENT('.parallax');
    let scrollPosicao=event.target.scrollTop;
    parallax.style.transform='translateY('+scrollPosicao * .7 +'px)';
});

