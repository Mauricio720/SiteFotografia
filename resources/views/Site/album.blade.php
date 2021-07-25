@extends('layouts.templateSite')
    <head>
        <meta name="keywords" content="{{$palavrasChave}}">
        <meta name="p:domain_verify" content="aa96d7adf8d5682cfe3006f0a8433d00"/>
        <meta name="description" content="{{$descricaoSite}}">
        <meta name="author" content="Marcos Sousa">
        <meta property="og:title" content="Marcos Sousa">
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="{{route('foto.album',['slugCategoria'=>$nomeCategoria,'slugAlbum'=>$album->slug])}}">
        <meta property="og:image:alt" content="{{$album->tituloFoto}}">
        <meta property="og:title" content="{{$album->tituloAlbum}}">
        <meta property="og:description" content="{{$album->descricaoAlbum}}">
        <meta property="og:image" content="{{asset('storage/'.$album->fotoCapa)}}" />
        <meta property="og:type" content="website"/>
        <meta property="og:image:width" content="750">
        <meta property="og:image:height" content="500">
        <meta property="og:locale" content="pt_br">  
        <link rel="icon" type="imagem/png" href="{{asset("storage/imagens/configImagens/logo/".$logo)}}" />
        <script type="text/javascript">
            // Popup window code
            function newPopup(url) {
            popupWindow = window.open(
            url,'popUpWindow','height=300,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
            }
        </script>

        <script
            type="text/javascript"
            async defer
            src="//assets.pinterest.com/js/pinit.js"
        ></script>
        <link rel="stylesheet" href="{{asset('css/defaultCss.css')}}">
        <link rel="stylesheet" href="{{asset('css/album.css')}}">
        
    </head>

    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v7.0" nonce="UwXMwHEh">
    </script>
    
    @section('content')
    
    <h4 class="titulo">{{$album->tituloAlbum}}</h4>
    
    <div class="fichaTecnica">
        {!!$fichaTecnica!!}
    </div>

    @if(count($picturesFromAlbum)>0)
    <div id="carouselAlbum" class="carousel slide carouselAlbum" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($picturesFromAlbum as $key=>$picture)
                @if($key==0)  
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="{{asset("storage/".$picture->caminhoFoto)}}" 
                            alt="{{$picture->tituloFoto}}">
                        
                        <div class="areaCompartilhar">
                            <div class="areaCompartilhar__conteudo">
                                
                                <a href="javascript:newPopup('https://www.facebook.com/sharer/sharer.php?u={{route('foto.album',['slugCategoria'=>$nomeCategoria,'slugAlbum'=>$album->slug])}}');"
                                    class="areaCompartilhar__icon">
                                    <img src="{{asset('storage/imagens/iconsSite/facebook.png')}}" 
                                        width="100%" height="100%">
                                </a>    

                                <a target="_blank" href="https://api.whatsapp.com/send?text={{route('foto.album',['slugCategoria'
                                    =>$slugCategoria,'slugAlbum'=>$album->slug])}}" class="areaCompartilhar__icon"> 
                                    <img src="{{asset('storage/imagens/iconsSite/whatsAppBlack.png')}}" 
                                        width="100%" height="100%">                        
                                </a>
                                <a href="https://www.pinterest.com/pin/create/button/" class="areaCompartilhar__icon" data-pin-custom="true" 
                                     data-pin-tall="true" data-pin-save="false" data-pin-do="buttonPin" 
                                     data-pin-media="{{asset("storage/".$picture->caminhoFoto)}}">
                                    <img src="{{asset('storage/imagens/iconsSite/pinterest.png')}}" 
                                         width="100%" height="100%">  
                                </a>
                            </div>
                        </div>
                    </div>
                @else    
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset("storage/".$picture->caminhoFoto)}}" 
                        alt="{{$picture->tituloFoto}}">
                    
                    <div class="areaCompartilhar">
                        <div class="areaCompartilhar__conteudo">
                            <a href="javascript:newPopup('https://www.facebook.com/sharer/sharer.php?u={{route('foto.album',['slugCategoria'=>$slugCategoria,'slugAlbum'=>$album->slug])}}');"
                                class="areaCompartilhar__icon">
                                <img src="{{asset('storage/imagens/iconsSite/facebook.png')}}" 
                                    width="100%" height="100%">
                            </a>    

                            <a target="_blank" href="https://api.whatsapp.com/send?text={{route('foto.album',['slugCategoria'
                                =>$slugCategoria,'slugAlbum'=>$album->slug])}}" class="areaCompartilhar__icon"> 
                                <img src="{{asset('storage/imagens/iconsSite/whatsAppBlack.png')}}" 
                                    width="100%" height="100%">                        
                            </a>
                            
                            <a href="https://www.pinterest.com/pin/create/button/" class="areaCompartilhar__icon" 
                                data-pin-custom="true" data-pin-tall="true" data-pin-save="false" 
                                data-pin-do="buttonPin" data-pin-media="{{asset("storage/".$picture->caminhoFoto)}}">
                                <img src="{{asset('storage/imagens/iconsSite/pinterest.png')}}" 
                                        width="100%" height="100%">  
                            </a>
                        </div>
                    </div>
                </div>
            @endif
             @endforeach
        </div>

        <a class="carousel-control-prev" href="#carouselAlbum" data-slide="prev">
            <span class="carousel-control-prev-icon"
            style="background-image: url({{asset("storage/imagens/iconsSite/return.png")}}) 
            !important;"></span>
        </a>

        <a class="carousel-control-next" href="#carouselAlbum" data-slide="next">
            <span class="carousel-control-next-icon"
            style="background-image: url({{asset("storage/imagens/iconsSite/next.png")}}) 
            !important;" ></span>
        </a>  
    </div>
    @else 
        <h3><center>Em breve novas fotos!!!</center></h3>

     @endif  

    <div class="comentarios">
        <h5>Deixe seu comentario:</h5>
        <div class="fb-comments" data-href="http://marcossousafotografia.com"
            data-numposts="5" data-width="100%">
        </div>
                
        <meta name="p:domain_verify" content="aa96d7adf8d5682cfe3006f0a8433d00"/>
    </div>

    
    @if (count($albuns)>0)
    <h5>Veja Mais</h5>
    <div class="containerOutrosAlbuns">
        @foreach ($albuns as $album)
            <a class="outrosAlbuns" href="{{route('foto.album',['slugCategoria'=>$album->slugCategoria,'slugAlbum'=>$album->slug])}}">
                <div class="outrosAlbuns">
                    <img src="{{asset('storage/'.$album->fotoCapa)}}" alt="{{$album->tituloAlbum}}" width="100%">      
                </div>
            </a>
        @endforeach
    </div>
    @endif

    <div class="contato">
        <div class="contato__item">
            <h5 class="contato__subitem contato__subitem--titulo">Marcos Sousa / Contato</h5>
            <div class="contato__subitem contato__subitem--local">SÃO PAULO / SP</div>
        </div>
        <div class="contato__item contato__item--info">
            <div class="contato__email">
                {{$emailContato}}
            </div>
            <div class="contato__tel">
                {{$numContato}}
            </div>
        </div>
        <div class="contato__item contato__item--link">
            <a href="{{route('contato')}}" class="contato__btnContato">
                Vamos conversar!
            </a>
        </div>
    </div>

    <div class="instagram">
       
       
    </div>

    <script src="{{asset('js/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('js/jquery.mousewheel.min.js')}}"></script>
    
    <script>
        $(function() {
            $(".areaAlbunsOthers").mousewheel(function(event, delta) {
            this.scrollLeft -= (delta * 30);
            event.preventDefault();
            });
        });
    </script>

    <script src="{{asset('js/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('js/jquery.mousewheel.min.js')}}"></script>
    <script>
        $(function() {
            $(".containerOutrosAlbuns").mousewheel(function(event, delta) {
            this.scrollLeft -= (delta * 30);
            event.preventDefault();
            });
        });
    </script>
     
</body>
</html>
@endsection