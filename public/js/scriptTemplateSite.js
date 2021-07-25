document.addEventListener('contextmenu', event => event.preventDefault());

ONLY_HTMLELEMENT('.menu--mobile').style.display="flex";;
 ONLY_HTMLELEMENT('.menuMobileBtn').addEventListener('click',(event)=>{
    
    setTimeout(()=>{
        ONLY_HTMLELEMENT('.menu--mobile').style.width="200px";
        setTimeout(()=>{
            ONLY_HTMLELEMENT('.menu--mobile').style.opacity=1;
            setTimeout(()=>{
                ONLY_HTMLELEMENT('.menu--mobile .menuLista').style.display="flex";
            },200);
        },150)
    },50);
    
    
})


ONLY_HTMLELEMENT('.fechar--mobile').addEventListener('click',(event)=>{
    setTimeout(()=>{
        ONLY_HTMLELEMENT('.menu--mobile .menuLista').style.display="none";
        ONLY_HTMLELEMENT('.menu--mobile').style.opacity=0;
        ONLY_HTMLELEMENT('.menu--mobile').style.width="0px";
    },20);
});

$(()=>{
   let options = {
       get: "@marcossousafotografia",
       limit: 4,
       imageSize:640,
       template:'<a class="instagram__foto" target="_blank" href="{{link}}">'
                    +'<img src="{{image}}" alt="{{caption}}" width="100%"/>'
                    +'<div class="instagramHover">'  
                        +'<div class="instagramHover__areaItems">' 
                            +'<div class="intagramHover__item intagramHover__item--like">'  
                                +'<div class="intagramHover__icon">'
                                    +'<img src='+heartWhite+' alt="heartWhite" width="100%">'
                                +'</div>'
                                +'<span class="intagramHover__num">{{likes}}</span>' 
                            +'</div>'
                            
                            +'<div class="intagramHover__item intagramHover__item--coments">'  
                                +'<div class="intagramHover__icon">'
                                    +'<img src='+comments+' alt="comments" width="100%">'
                                +'</div>'
                                +'<span class="intagramHover__num">{{comments}}</span>' 
                            +'</div>'
                        +'</div>'
                    +'</div>'
               +'</div>'   
           +'</a>',   
       };
   
        $(".instagram").instastory(options);
});