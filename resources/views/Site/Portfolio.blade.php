@extends('layouts.templateSite')

    <head>
        <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
        <title>Histórias | Fotografo de casamento, São Paulo, Suzano, Poá, Marcos Sousa Fotografia</title>
        <meta name="description" content="Fotografo de Casamentos, Pré Wedding, Fotos Espontâneas, Ensaios de Casal, 
            Gestantes, Corporativos, em São Paulo, Suzano, Poá, Marcos Sousa Fotografia">
        <meta property="og:url" content="{{route('homeSite')}}">
        <meta property="og:title" content="Marcos Sousa">
        <meta property="og:description" content="{{$descricaoSite}}">
        <meta property="og:locale" content="pt_br"> 
        <meta property="og:image" content="{{asset('storage/'.$logo)}}" />
        <meta property="og:type" content="website"/>
    </head>

    @section('content')
    @foreach ($category as $item)
    <div class="linhaTempo">
        <h3 class="linhaTempo__titulo">{{$item->nomeCategoria}}</h3>
        <div class="btnLinhaTempo esquerdaLinhaTempo">
            <img src="{{asset('storage/imagens/iconsSite/return.png')}}" width="80%">
        </div>
        
        <div class="albumArea">
            @foreach($albuns as $album)
            @if($album->idCategoria == $item->idCategoria)
            <div class="albumConteudo">
                
                <a href="{{route('foto.album',['slugCategoria'=>$item->slugCategoria,'slugAlbum'=>$album->slug])}}" class="albumConteudo__album">
                    <img src="{{ asset("storage/".$album->fotoCapa)}}" alt="{{$album->tituloFoto}}" width="100%">
                    <div class="albumConteudo__hover">
                        <span class="albumConteudo__rotulos">+</span>
                        <span class="albumConteudo__rotulos albumConteudo__rotulos--vejaMais">Veja Mais</span>
                    </div>
                </a>
                <div class="albumConteudo__infoArea">
                    <div class="albumConteudo__info albumConteudo__info--titulo">
                        {{$album->tituloAlbum}}
                    </div>

                    <div class="albumConteudo__info albumConteudo__info--descricao">
                        {{$album->descricaoAlbum}}
                    </div>
                </div>

                <div class="albumConteudo__areaVisualizacoesLikes">
                    <div class="albumConteudo__infoVisualizacoesLikes albumConteudo__infoVisualizacoesLikes--view">
                        <div class="albumConteudo__icon">
                            <img src="{{asset('storage/imagens/iconsSite/eye.png')}}" width="20">
                        </div>
                        <div class="albumConteudo__icon albumConteudo__icon--info">
                            {{$album->view}}
                        </div>
                    </div>

                    <div class="albumConteudo__infoVisualizacoesLikes">
                        <div class="albumConteudo__icon like" key="{{$album->idAlbum}}">
                            <img src="{{asset('storage/imagens/iconsSite/heart.png')}}" width="85%" height="80%">
                        </div>
                        <div class="albumConteudo__icon">
                            {{$album->curtida}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
        </div>
        <div class="btnLinhaTempo direitaLinhaTempo">
            <img src="{{asset('storage/imagens/iconsSite/next.png')}}" width="80%">
        </div>
    @endforeach
    </div>

    <div class="contato">
        <div class="contato__item">
            <h5 class="contato__subitem contato__subitem--titulo">Marcos Sousa / Contato</h5>
            <div class="contato__subitem contato__subitem--local">SÃO PAULO / SP</div>
        </div>
        <div class="contato__item contato__item--info">
            <h1 style="font-size: 20px;">Histórias</h1>
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
     

    <script>
        var heartRed="{{asset('storage/imagens/iconsSite/heartRed.png')}}";
        var urlLike="{{route('albumLike')}}";
        var heartBlack="{{asset('storage/imagens/iconsSite/heart.png')}}";
        var urlDeslike="{{route('albumDeslike')}}";
    </script>
    <script src="{{asset('js/scriptPortfolio.js')}}"></script>
</body>
</html>
@endsection