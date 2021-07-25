var palavrasAdicionadas=[];
var blocoPalavra=ONLY_HTMLELEMENT('.blocoPalavra');
var areaPalavrasChave=ONLY_HTMLELEMENT('.areaPalavrasChave');

pegarPalavrasChave();
acaoApagarBloco(palavrasAdicionadas);

function pegarPalavrasChave(){
    let palavrasChave=ONLY_HTMLELEMENT('#campoPalavraChave').value;
    palavrasAdicionadas=palavrasChave.split(',');
}

ONLY_HTMLELEMENT('#addPalavra').addEventListener('click',(event)=>{
    event.preventDefault();
    let palavra=ONLY_HTMLELEMENT('#palavraChaveInserir').value;
    if(palavra!=""){
        palavrasAdicionadas.push(palavra);
        ONLY_HTMLELEMENT('#palavraChaveInserir').value="";
        setarBlocos();
        escreverPalavrasNoInput();
    }
})

function setarBlocos(){
    areaPalavrasChave.innerHTML="";
    [...palavrasAdicionadas].map((palavra,index)=>{
        let bloco=blocoPalavra.cloneNode(true);
        bloco.style.display="flex";
        bloco.setAttribute('index',index);
        bloco.querySelector('.palavra').innerHTML=palavra;
        areaPalavrasChave.append(bloco);
        
    })

    acaoApagarBloco();
}

function renomearIndex(){
    let blocos=ALL_HTMLELEMENT('.blocoPalavra');
    [...blocos].map((bloco,index)=>{
        bloco.setAttribute('index',index);
    })
}

function acaoApagarBloco(){
    let apagarBtns=ALL_HTMLELEMENT('.blocoPalavra .apagar');
    [...apagarBtns].map((apagar)=>{
        apagar.addEventListener('click',(event)=>{
            let index=parseInt(event.target.closest('.blocoPalavra').getAttribute('index'));
            console.log(index);
            //event.target.closest('.blocoPalavra').remove();
            
            palavrasAdicionadas.splice(index,1);
            console.log(palavrasAdicionadas);
            setarBlocos();
            renomearIndex();
            escreverPalavrasNoInput();
            
        });
    })
}

function escreverPalavrasNoInput(){
    ONLY_HTMLELEMENT('#campoPalavraChave').value="";
    [...palavrasAdicionadas].map((palavra,index)=>{
        let palavrasInput=ONLY_HTMLELEMENT('#campoPalavraChave').value;
        if(index==0){
            ONLY_HTMLELEMENT('#campoPalavraChave').value=palavrasInput+palavra;
        }else{
            ONLY_HTMLELEMENT('#campoPalavraChave').value=palavrasInput+','+palavra;
        }
    });
}