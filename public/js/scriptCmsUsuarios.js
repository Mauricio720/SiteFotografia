var checks=ALL_HTMLELEMENT('.permissoesCheck');
var checksAdm=ONLY_HTMLELEMENT('#admCheck')

if(checksAdm.checked){
    for (let i = 0; i < checks.length; i++) {
        checks[i].checked=false;
        checks[i].disabled="false";
    }
}

checksAdm.addEventListener('change',(event)=>{
    if(event.currentTarget.checked){
        for (let i = 0; i < checks.length; i++) {
            checks[i].checked=false;
            checks[i].disabled="false";
        }
    }else if(event.target.checked==false){
        for (i = 0; i < checks.length; i++) {
            checks[i].removeAttribute('disabled')
        }
    }
});

[...checks].map((check)=>{
    check.addEventListener('change',(event)=>{
        if(verificarTodosOsChecks()){
            for (let i = 0; i < checks.length; i++) {
                checks[i].checked=false;
                checks[i].disabled="false";
                checksAdm.checked=true;
            }
        }else{
            for (i = 0; i < checks.length; i++) {
                checks[i].removeAttribute('disabled')
                
            }
        }
    })
})

function verificarTodosOsChecks(){
    retorno=true;
    
    for (i = 0; i < checks.length; i++) {
        if(checks[i].checked==false){
            return false;
        }
    }

    return retorno;
}
