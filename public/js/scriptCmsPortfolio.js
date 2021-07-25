let excluirAlbum=ALL_HTMLELEMENT('.btnExcluirAlbum');
[...excluirAlbum].map((item)=>{
    item.addEventListener('click',(event)=>{
        event.preventDefault();
        let modal=ONLY_HTMLELEMENT('#modalConfirmacao');
        modal.style.display="block";
        modal.querySelector('.modal-title').innerHTML="Tem Certeza que deseja excluir esse album?";
        modal.querySelector('.alert').innerHTML="Todas as fotos do album serão excluidas!";
        
        modal.querySelector('#confirmarModal').addEventListener('click',(e)=>{
            window.location = item.href; 
        })
    
    })
    
})

$(function() {
    $(".lineTimeArea").mousewheel(function(event, delta) {
        this.scrollLeft -= (delta * 30);
        event.preventDefault();
    });
 });



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


