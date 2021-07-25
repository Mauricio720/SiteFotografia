let menuOpen=true;

if(ONLY_HTMLELEMENT('.notificacaoAlerta')!=null){
    setInterval(() => {
        ONLY_HTMLELEMENT('.notificacaoAlerta').style.backgroundColor="rgba(0, 220, 255, 0.82)";
        setTimeout(()=>{
            ONLY_HTMLELEMENT('.notificacaoAlerta').style.backgroundColor="transparent";
        },500);
    }, 1000);
}

let alertaOpen=false;

if(ONLY_HTMLELEMENT('#notificacao')!=null){
ONLY_HTMLELEMENT('#notificacao').addEventListener('click',()=>{
    if(alertaOpen==false){
        setTimeout(()=>{
            ONLY_HTMLELEMENT('.listaNotificacoes').style.display="flex";
            alertaOpen=true;
        },800)
    }else{
        setTimeout(()=>{
            ONLY_HTMLELEMENT('.listaNotificacoes').style.display="none";
            alertaOpen=false;
        },800)
    }
})
}

ONLY_HTMLELEMENT('.menuOpen').addEventListener('click',(event)=>{
    if(menuOpen===false){
        ONLY_HTMLELEMENT('.menu').style.width="240px";
        menuOpen=true;
    }else{
        ONLY_HTMLELEMENT('.menu').style.width="65px";
        menuOpen=false;
    }   
})



