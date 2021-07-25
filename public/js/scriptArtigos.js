var artigos=ALL_HTMLELEMENT('.artigo');
var numArtigos=6;
var page=ONLY_HTMLELEMENT('.pagina');


[...artigos].map((artigo,index)=>{
    if(index<numArtigos){
        artigo.style.display="block"
        setInterval(()=>{
            artigo.style.opacity=1;
        },500);
    }
});

function mostrarArtigos(){
    artigos.forEach((artigo,index)=>{
       if(artigo.closest('.row').getBoundingClientRect().top < window.innerHeight){
          if(index>=numArtigos){
            artigo.style.display="block";
            setInterval(()=>{
                artigo.style.opacity=1;
            },500);
            
            }
        }
    })
 }

 page.addEventListener('scroll',()=>{
    mostrarArtigos();
 });