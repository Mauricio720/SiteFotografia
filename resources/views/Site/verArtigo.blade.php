@extends('layouts.templateSite')
<head>
    <meta property="og:url" content="{{route('verArtigoSite',['slugArtigo'=>$artigo->slug])}}">
    <meta property="og:title" content="{{$artigo->tituloArtigo}}">
    <meta property="og:description" content="{{$artigo->descricaoArtigo}}">
    <meta property="og:image" content="{{asset('storage/'.$artigo->fotoCapa)}}" />
    <meta property="og:type" content="article"/>
    <meta property="og:image:width" content="750">
    <meta property="og:image:height" content="500">
    <meta property="og:locale"     content="pt_br">    
    <link rel="stylesheet" href="{{asset('css/verArtigo.css')}}">
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
    
</head>
@section('content')
    <div class="banner">
        <img class="parallax" src="{{asset('storage/'.$artigo->fotoCapa)}}" alt="" class="parallax"> 
        <div class="bannerHover" >
            <h2 class="bannerHover__item bannerHover__item--titulo">{{$artigo->tituloArtigo}}</h2>
            <h4 class="bannerHover__item bannerHover__item--descricao">
                {{$artigo->descricaoArtigo}}
            </h4>
        </div>
    </div>
    <div class="containerArtigo">
        <div class="conteudoArtigo">
            {!!$artigo->html!!}
        </div><br>
        <div class="conteudoArtigo__autor">Autor: {{$artigo->autor}}</div><br>
        
        <div class="areaCompartilhar">
            <div class="areaCompartilhar__conteudo">
                <a href="javascript:newPopup('https://www.facebook.com/sharer/sharer.php?u={{route('verArtigoSite',['slugArtigo'=>$artigo->slug])}}');" 
                    class="areaCompartilhar__icon">
                    <img src="{{asset('storage/imagens/iconsSite/facebook.png')}}" 
                        width="100%" height="100%">
                </a>
                <a href="https://api.whatsapp.com/send?text={{route('verArtigoSite',['slugArtigo'=>$artigo->slug])}}"
                     class="areaCompartilhar__icon"
                     target="_blank"> 
                    <img src="{{asset('storage/imagens/iconsSite/whatsAppBlack.png')}}" 
                        width="100%" height="100%">                        
                </a>
                <a href="https://www.pinterest.com/pin/create/button/" class="areaCompartilhar__icon" data-pin-tall="true" 
                    data-pin-save="false"  data-pin-do="buttonPin" data-pin-custom="true" data-pin-media="{{asset('storage/'.$artigo->fotoCapa)}}">
                    <img src="{{asset('storage/imagens/iconsSite/pinterest.png')}}" 
                            width="100%" height="100%"> 
                </a>
            </div>
        </div>
        
        @if(count($arquivosArtigos)>0)
        <div class="containerAreaArquivos">
            <div class="areaArquivos">
                @foreach ($arquivosArtigos as $arquivo)
                <a class="arquivos" href="{{route('clienteEbook',
                    ['nomeArquivo'=>$arquivo->nomeArquivo])}}">
                        {{$arquivo->descricaoLink}}</a><br>   
                @endforeach
            </div>
        </div>
        @endif
    
        <div class="comentsArea">
            <h5>Deixe seu comentario:</h5>
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v8.0" 
            nonce="ViuSPSrT"></script>
            <div class="fb-comments" data-href="http://marcossousafotografia.com/" 
            data-numposts="5" data-width="100%"></div>
        </div><br><br>

        <h5>Veja Mais</h5>
        <div class="containerOutrosArtigos">
                @foreach ($outrosArtigos as $artigo)
                    <a href="{{route('verArtigoSite',['slugArtigo'=>$artigo->slug])}}">
                    <article class="outrosArtigos" style="background-image: 
                        url('{{asset("storage/".$artigo->fotoCapa)}}');">
                            <div class="outrosArtigos__hover">
                                <div class="outrosArtigos__item outrosArtigos--titulo">
                                    {{$artigo->tituloArtigo}}
                                </div>

                                <div class="outrosArtigos__item outrosArtigos--descricao">
                                    {{$artigo->descricaoArtigo}}
                                </div>
                            </div>        
                    </article>
                    </a>
                @endforeach
            </div>

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
    </div>
    <script>
        ONLY_HTMLELEMENT('.pagina').addEventListener('scroll',(event)=>{
            const parallax=ONLY_HTMLELEMENT('.parallax');
            let scrollPosicao=event.target.scrollTop;
            parallax.style.transform='translateY('+scrollPosicao * .7 +'px)';
        });
    </script>
    
    <script src="{{asset('js/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('js/jquery.mousewheel.min.js')}}"></script>
    <script>
        $(function() {
            $(".containerOutrosArtigos").mousewheel(function(event, delta) {
            this.scrollLeft -= (delta * 30);
            event.preventDefault();
            });
        });
    </script>
@endsection