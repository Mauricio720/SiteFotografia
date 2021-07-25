@extends('layouts.templateSite')

<head>
    <link rel="stylesheet" href="{{asset('css/defaultCss.css')}}">
    <link rel="stylesheet" href="{{asset('css/artigos.css')}}">
    <title>Blog | Fotografo de casamento, São Paulo, Suzano, Poá, Marcos Sousa Fotografia</title>
    <meta name="description" content="Fotografo de Casamentos, Pré Wedding, Fotos Espontâneas, Ensaios de Casal, 
        Gestantes, Corporativos, São Paulo, Suzano, Poá, Marcos Sousa Fotografia.">
    <meta property="og:url" content="{{route('homeSite')}}">
    <meta property="og:title" content="Marcos Sousa">
    <meta property="og:description" content="{{$descricaoSite}}">
    <meta property="og:locale" content="pt_br"> 
    <meta property="og:image" content="{{asset('storage/'.$logo)}}" />
    <meta property="og:type" content="website"/>
    
</head>

@section('content')
<section class="artigosPage">
    <div class="container-fluid" style="margin-top: 10px;">
        <?php
            $linha=0;
                $contador=0;
        ?>

        @for ($i = 0; $i < count($dadosArtigo); $i++)
            
            @if($linha==0)
                <div class="row">
                    <div class="col-sm nopadding">
                        <article class="artigo" style="display:none;
                        background-image: url({{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}})">
                            <a href="{{route('verArtigoSite',['slugArtigo'=>$dadosArtigo[$i]['slug']])}}">
                                
                                <img src="{{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}}" 
                                alt="{{$dadosArtigo[$i]['tituloArtigo']}}" width="5" height="5">
                                <div class="areaInfoArtigo">
                                    <div class="tituloArtigo">
                                        {{$dadosArtigo[$i]['tituloArtigo']}}
                                    </div>
    
                                    <div class="descricaoArtigo">
                                        {{$dadosArtigo[$i]['descricaoArtigo']}}
                                    </div>
                                </div>
                            </a>
                        </article> 
                    </div>
                </div>
            @endif

            @if($linha==1)
            <div class="row">
                <div class="col-sm-8 nopadding">
                    <article class="artigo" style="display:none;
                    background-image: url({{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}})">
                        <a href="{{route('verArtigoSite',['slugArtigo'=>$dadosArtigo[$i]['slug']])}}">
                            <img src="{{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}}" 
                                alt="{{$dadosArtigo[$i]['tituloArtigo']}}" width="5" height="5">
                            <div class="areaInfoArtigo">
                                <div class="tituloArtigo">
                                    {{$dadosArtigo[$i]['tituloArtigo']}}
                                </div>

                                <div class="descricaoArtigo">
                                    {{$dadosArtigo[$i]['descricaoArtigo']}}
                                </div>
                            </div>
                        </a>
                    </article> 
                </div>

            @elseif($linha==2)
                    <div class="col-sm-4 nopadding">
                        <article class="artigo" style="display:none;
                        background-image: url({{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}})">
                            <a href="{{route('verArtigoSite',['slugArtigo'=>$dadosArtigo[$i]['slug']])}}">
                                <img src="{{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}}" 
                                alt="{{$dadosArtigo[$i]['tituloArtigo']}}" width="5" height="5">
                                <div class="areaInfoArtigo">
                                    <div class="tituloArtigo">
                                        {{$dadosArtigo[$i]['tituloArtigo']}}
                                    </div>
    
                                    <div class="descricaoArtigo">
                                        {{$dadosArtigo[$i]['descricaoArtigo']}}
                                    </div>
                                </div>
                            </a>
                        </article> 
                    </div>
            </div>
            @endif

            @if($linha==3)
            <div class="row">
                <div class="col-sm-4 nopadding">
                    <article class="artigo" style="display:none;
                    background-image: url({{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}})">
                        <a href="{{route('verArtigoSite',['slugArtigo'=>$dadosArtigo[$i]['slug']])}}">
                            <img src="{{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}}" 
                                alt="{{$dadosArtigo[$i]['tituloArtigo']}}" width="5" height="5">
                            <div class="areaInfoArtigo">
                                <div class="tituloArtigo">
                                    {{$dadosArtigo[$i]['tituloArtigo']}}
                                </div>

                                <div class="descricaoArtigo">
                                    {{$dadosArtigo[$i]['descricaoArtigo']}}
                                </div>
                            </div>
                        </a>
                    </article> 
                </div>

            @elseif($linha==4)
                    <div class="col-sm-8 nopadding">
                        <article class="artigo" style="display:none;
                        background-image: url({{asset('storage/'.$dadosArtigo[$i]['fotoCapa'])}})">
                            <a href="{{route('verArtigoSite',['slugArtigo'=>$dadosArtigo[$i]['slug']])}}">
                                <div class="areaInfoArtigo">
                                    <div class="tituloArtigo">
                                        {{$dadosArtigo[$i]['tituloArtigo']}}
                                    </div>
    
                                    <div class="descricaoArtigo">
                                        {{$dadosArtigo[$i]['descricaoArtigo']}}
                                    </div>
                                </div>
                            </a>
                        </article> 
                    </div>
            </div>
            @endif
            <?php
            if($linha<4){
                $linha++;
            }else{
                $linha=0;
            }
            ?>
        @endfor
    </div>
    

    <div class="contato">
        <div class="contato__item">
            <h5 class="contato__subitem contato__subitem--titulo">Marcos Sousa / Contato</h5>
            <div class="contato__subitem contato__subitem--local">SÃO PAULO / SP</div>
        </div>
        <div class="contato__item contato__item--info">
            <h1 style="font-size: 20px;">Blog</h1>
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
    
    <script src="{{asset('js/scriptArtigos.js')}}"></script>
</section>
    
@endsection