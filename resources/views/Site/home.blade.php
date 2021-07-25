@extends('layouts.templateSite')
    <head>
        <meta name="keywords" content="{{$palavrasChave}}">
        <meta name="p:domain_verify" content="aa96d7adf8d5682cfe3006f0a8433d00"/>
        <meta name="description" content="{{$descricaoSite}}">
        <meta name="author" content="Marcos Sousa">
        <meta property="og:url" content="{{route('homeSite')}}">
        <meta property="og:title" content="Marcos Sousa">
        <meta property="og:description" content="{{$descricaoSite}}">
        <meta property="og:locale" content="pt_br"> 
        <meta property="og:image" content="{{asset('storage/'.$logo)}}" />
        <meta property="og:type" content="website"/>
        <link rel="stylesheet" href="{{asset('css/home.css')}}">
    </head>
    @section('content')
    
    <div class="areaFotos">
        <div class="areaFotos__fotos">
            <img width="100%">
        </div>
    </div>

    <div class="modalPrincipal">
        <div class="fechar fechar--modal">
            <img src="{{asset('storage/imagens/iconsSite/close.png')}}"  width="100%">
        </div>
        <div class="modalPrincipal__body">
            <div id="carroselHome" class="carousel slide carouselFotos" data-ride="carousel">
                <div class="carousel-inner">
                @foreach ($favoritePictures as $key=>$item)
                    <div class="carousel-item"  key="{{$item->idFoto}}">
                        <img class="d-block w-100"  src="{{asset("storage/".$item->caminhoFoto)}}" alt="{{$item->tituloFoto}}">
                    </div>
                @endforeach  
                </div>

                <a class="carousel-control-prev" href="#carroselHome" data-slide="prev">
                    <span class="carousel-control-prev-icon"
                        style="background-image: url({{asset("storage/imagens/iconsSite/return.png")}}) 
                        !important;"></span>
                    </a>
        
                <a class="carousel-control-next" href="#carroselHome" data-slide="next">
                    <span class="carousel-control-next-icon"
                    style="background-image: url({{asset("storage/imagens/iconsSite/next.png")}}) 
                    !important;" ></span>
                </a>
            </div>
        </div>
    </div>
    
    @if(count($depoimentos)>0)
    <div class="depoimentos">
        <h5><center>Depoimentos</center></h5>
        <div id="slideDepoimentos" class="slide carousel depoimentos__slideShow" data-interval="10000" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($depoimentos as $key=>$depoimento)
                    @if($key==0)  
                        <div class="carousel-item active">
                     @else 
                        <div class="carousel-item">
                    @endif
                     <div class="depoimentos__texto">
                        {!!$depoimento->depoimento!!}
                    </div>
                        <div class="depoimentos__autor">
                            {{$depoimento->autor}}
                        </div>
                </div>
                @endforeach 
            </div>
            
            <a class="carousel-control-prev" href="#slideDepoimentos" data-slide="prev">
                <span class="carousel-control-prev-icon depPrevNext"
                style="background-image: url({{asset("storage/imagens/iconsSite/return.png")}}) 
                !important;"></span>
            </a>

            <a class="carousel-control-next" href="#slideDepoimentos" data-slide="next">
                <span class="carousel-control-next-icon depPrevNext"
                style="background-image: url({{asset("storage/imagens/iconsSite/next.png")}}) 
                !important;" ></span>
            </a>   
            
            <ol class="carousel-indicators">
                @foreach ($depoimentos as $key=>$depoimento)
                        @if($key==0)  
                             <li data-target="#slideDepoimentos" data-slide-to="{{$key}}" class="active"></li>
                        @else
                            <li data-target="#slideDepoimentos" data-slide-to="{{$key}}"></li>
                        @endif
                    @endforeach
                
            </ol>
        </div>
    </div>
    @endif

    <div class="contato">
        <div class="contato__item">
            <h5 class="contato__subitem contato__subitem--titulo">Marcos Sousa / Contato</h5>
            <div class="contato__subitem contato__subitem--local">SÃO PAULO / SP</div>
        </div>
        <div class="contato__item contato__item--info">
            <h1 style="font-size: 20px;">Marcos Sousa Fotografia</h1>
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
        var url="{{route('foto.allFavoritePicture')}}";
        var routeImg="{{asset('/storage')}}";
    </script> 
    <script src="{{asset('js/scriptHome.js')}}"></script>
@endsection
