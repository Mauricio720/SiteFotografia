
verificarQntdAlbuns();


let btnsProximos=ALL_HTMLELEMENT('.direitaLinhaTempo');
var click=0;
[...btnsProximos].map((btnProximo)=>{
    btnProximo.addEventListener('click',(event)=>{
        click++;
        if(click==1){
            let lineTime=event.target.closest('.linhaTempo').querySelector('.albumArea');
            
            arrastarAlbunsParaDireita(lineTime);
            setTimeout(()=>{
                click=0;
            },500);
        }
        
    })
});



let btnsAnterior=ALL_HTMLELEMENT('.esquerdaLinhaTempo');
if(btnsAnterior !=null){
    [...btnsAnterior].map((btnAnterior)=>{
        btnAnterior.addEventListener('click',(event)=>{
            click++;
            if(click==1){
                let lineTime=event.target.closest('.linhaTempo').querySelector('.albumArea');
                arrastarAlbunsParaEsquerda(lineTime);
                setTimeout(()=>{
                    click=0;
                },500);
            }
        })
    });
}


function verificarQntdAlbuns(){
    let lineTimes=ALL_HTMLELEMENT('.linhaTempo');
    [...lineTimes].map((lineTime)=>{
        let larguraAlbum=parseInt(ONLY_HTMLELEMENT('.albumConteudo__album').offsetWidth); 
        
        let albuns=lineTime.querySelectorAll('.albumConteudo__album');
        quantdAlbum=albuns.length;
        let totalLarguraAlbuns=larguraAlbum*quantdAlbum-7;
        let larguraLineTime=lineTime.offsetWidth;
        
        
        if(totalLarguraAlbuns>larguraLineTime){
            lineTime.querySelector('.direitaLinhaTempo').style.display="flex";
        }else{
            lineTime.querySelector('.direitaLinhaTempo').style.display="none";
        }
    })
}


function arrastarAlbunsParaEsquerda(lineTime){
    let larguraAlbum=parseInt(ONLY_HTMLELEMENT('.albumConteudo__album').offsetWidth);
    
    let marginLeftAlbum=parseInt(document.defaultView
    .getComputedStyle(lineTime, null)
    .getPropertyValue('margin-left'));
    let albuns=lineTime.querySelectorAll('.albumConteudo__album');
    quantdAlbum=albuns.length;
    lineTime.nextElementSibling.style.display="flex";
    lineTime.style.marginLeft=(marginLeftAlbum+larguraAlbum)+quantdAlbum+'px';
    marginLeftAlbum= marginLeftAlbum+larguraAlbum+quantdAlbum;
    verificarPosicaoLeft(marginLeftAlbum,lineTime);
}

function arrastarAlbunsParaDireita(lineTime){
    
    let larguraAlbum=parseInt(ONLY_HTMLELEMENT('.albumConteudo__album').offsetWidth);
    
    let marginLeftAlbum=parseInt(document.defaultView
    .getComputedStyle(lineTime, null)
    .getPropertyValue('margin-left'));
    let albuns=lineTime.querySelectorAll('.albumConteudo__album');
    quantdAlbum=albuns.length;  
    lineTime.closest('.linhaTempo').querySelector('.esquerdaLinhaTempo').style.display="flex";
  
    lineTime.style.marginLeft=marginLeftAlbum-larguraAlbum-quantdAlbum+'px';
     marginLeftAlbum= marginLeftAlbum-larguraAlbum;
     verificarPosicaoRight(larguraAlbum,marginLeftAlbum,lineTime)

}

function verificarPosicaoLeft(marginLeft,lineTime){
   if(marginLeft>=0){
        lineTime.closest('.linhaTempo').querySelector('.esquerdaLinhaTempo').style.display="none";
    }    
}

function verificarPosicaoRight(larguraAlbum,marginLeft,lineTime){
    let albuns=lineTime.querySelectorAll('.albumConteudo__album');
    quantdAlbum=albuns.length;
    totalLarguraAlbuns=(larguraAlbum*quantdAlbum)*-1;
    if(window.innerWidth>=1366){
        totalLarguraAlbuns=totalLarguraAlbuns+(larguraAlbum*3);
    }else{
        totalLarguraAlbuns=totalLarguraAlbuns+(larguraAlbum*2);
    }

    
    if(marginLeft<=totalLarguraAlbuns){
        lineTime.closest('.linhaTempo').querySelector('.direitaLinhaTempo').style.display="none";
    }  
}


 verificarCookiesLike();

 function verificarCookiesLike(){
    let likes=ALL_HTMLELEMENT('.like');
        [...likes].map((like)=>{
            let key=like.getAttribute('key');
            let nomeStorage="like"+key;
            
            if(localStorage.getItem(nomeStorage)!=null){
                like.children[0].src=heartRed;;
            }
    });
 }

 let likes=ALL_HTMLELEMENT('.like');
 [...likes].map((like)=>{
    like.addEventListener('click',(event)=>{
        event.preventDefault();
        let key=event.currentTarget.getAttribute('key');
        let nomeStorage="like"+key;
        if(localStorage.getItem(nomeStorage)==null){
            localStorage.setItem(nomeStorage,true);
            event.currentTarget.children[0].src=heartRed;
            let numLike=parseInt(event.currentTarget.nextElementSibling.innerText);
            let totalLike=numLike+1;
            event.currentTarget.nextElementSibling.innerText=totalLike;
                
            $.ajax({
                url:urlLike,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                data:{'idAlbum':key},
            });

        }
      })
 })
 
 