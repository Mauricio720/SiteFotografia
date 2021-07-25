@extends('layouts.templateSite')
    <head>
        <link rel="stylesheet" href="{{asset('css/sobre.css')}}">
        <title>Marcos | Fotografo de casamento, São Paulo, Suzano, Poá, Marcos Sousa Fotografia</title>
        <meta name="description" content="Acreditamos que uma foto não é apenas pra registrar o que é bonito, mas na verdade, 
        em cada foto existe uma história, um sentimento, um sorriso, uma emoção...">
        <meta property="og:url" content="{{route('sobre')}}">
        <meta property="og:title" content="Marcos Sousa">
        <meta property="og:description" content="{{$descricaoSite}}">
        <meta property="og:locale" content="pt_br"> 
        <meta property="og:image" content="{{asset('storage/imagens/configImagens/bannerAbout/'.$bannerAbout)}}" />
        <meta property="og:type" content="website"/>
    </head>

    @section('content')
    <div class="banner">
        <img class="parallax" src="{{asset('storage/imagens/configImagens/bannerAbout/'.$bannerAbout)}}" alt="" class="parallax"> 
    </div>
    
    <div class="containerSobre">
        <div class="containerSobre__texto">
        {!!$sobre!!}
        </div>
        <div class="contato">
            <div class="contato__item">
                <h5 class="contato__subitem contato__subitem--titulo">Marcos Sousa / Contato</h5>
                <div class="contato__subitem contato__subitem--local">SÃO PAULO / SP</div>
            </div>
            <div class="contato__item contato__item--info">
                <h1 style="font-size: 20px;">Marcos</h1>
            </div>
            <div class="contato__item contato__item--link">
                <a href="{{route('contato')}}" class="contato__btnContato">
                    Vamos conversar!
                </a>
                <div class="contato__subitem" style="text-align: center;">
                    <div style="margin-top: 10px;">
                        {{$emailContato}}
                    </div>
                    <div>
                        {{$numContato}}
                    </div>
                </div>
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

@endsection