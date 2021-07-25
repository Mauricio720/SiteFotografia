<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>{{$tituloSite}}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  
    user-scalable=no,shrink-to-fit=no">    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="content-language" content="pt-BR">
    <meta name="keywords" content="{{$palavrasChave}}">
    <meta name="p:domain_verify" content="aa96d7adf8d5682cfe3006f0a8433d00"/>
    <meta name="description" content="{{$descricaoSite}}">
    <meta name="author" content="Marcos Sousa">
    <link rel="icon" type="imagem/png" href="{{asset("storage/imagens/configImagens/logo/".$logo)}}" />
    <link rel="stylesheet" href={{ asset('css/templateSite.css') }}>
    <link rel="stylesheet" href={{ asset('css/blogContent.css') }}>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/defaultCss.css') }}">
    <link rel="canonical" href="{{route('homeSite')}}" />

    
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172951562-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-172951562-1');
    </script>
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '519850345363034');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=519850345363034&ev=PageView&noscript=1"
    /></noscript>
</head>
<body>
    <header class="header" style="background-color: {{$corMenu}}">
        <div class="menuMobileBtn">
            <div class="menuMobileBtn__lineMenu"></div>
            <div class="menuMobileBtn__lineMenu"></div>
            <div class="menuMobileBtn__lineMenu"></div>
        </div>
        <a href="{{route('homeSite')}}" class="header__logo">
            <img src="{{asset("storage/imagens/iconsSite/logoMobile.png")}}" width="100%">
        </a>
    </header>
    
    <aside class="menu"  style="background-color: {{$corMenu}}">
        <div class="menu__item--arealogo">
            <a href="{{route('homeSite')}}" class="logo">
                <img src="{{asset('storage/imagens/configImagens/logo/'.$logo)}}" width="100%">
            </a>
        </div>
        <div class="menu__item menu__item--opcoes">
            <nav>
                <ul class="menuLista">
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('homeSite')}}">{{$menus[0]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('foto.portfolio')}}">{{$menus[1]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a  href="{{route('artigosSite')}}">{{$menus[2]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('sobre')}}" >{{$menus[3]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('contato')}}">{{$menus[4]->titulo}}</a></li>
                    
                </ul>
            </nav>
        </div>
        <div class="menu__item menu__item--redesSociais">
            <div class="redesSociais">
                <a target="_blank" href="{{$instagramLink}}" class="redesSociais__icon">
                    <img src="{{asset('storage/imagens/iconsSite/instagram.png')}}" width="100%">
                </a>
                <a target="_blank" href="{{$pinterestLink}}" class="redesSociais__icon">
                    <img src="{{asset('storage/imagens/iconsSite/pinterest.png')}}" width="100%">
                </a>
                <a target="_blank" href="{{$emailLink}}" class="redesSociais__icon">
                    <img src="{{asset('storage/imagens/iconsSite/email.png')}}" width="100%">
                </a>
            </div>
        </div>
    </aside>
    
    <aside class="menu menu--mobile"  style="background-color: {{$corMenu}}">
        <div class="fechar fechar--mobile">
            <img src="{{asset('storage/imagens/iconsSite/close.png')}}" width="100%">
        </div>
        <div class="menu__item--arealogo">
            <a href="./" class="logo">
                <img src="{{asset('storage/imagens/configImagens/logo/'.$logo)}}" width="100%">
            </a>
        </div>
        <div class="menu__item menu__item--opcoes">
            <nav>
                <ul class="menuLista">
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('homeSite')}}">{{$menus[0]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('foto.portfolio')}}">{{$menus[1]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('artigosSite')}}">{{$menus[2]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('sobre')}}" >{{$menus[3]->titulo}}</a></li>
                    <li class="menuLista__itemLista"  style="color:{{$corFonteMenu}};"><a href="{{route('contato')}}">{{$menus[4]->titulo}}</a></li>
                    
     		</ul>
            </nav>
        </div>
        <div class="menu__item menu__item--redesSociais">
            <div class="redesSociais">
                <a target="_blank" href="{{$instagramLink}}" class="redesSociais__icon">
                    <img src="{{asset('storage/imagens/iconsSite/instagram.png')}}" width="100%">
                </a>
                <a target="_blank" href="{{$pinterestLink}}" class="redesSociais__icon">
                    <img src="{{asset('storage/imagens/iconsSite/pinterest.png')}}" width="100%">
                </a>
                <a target="_blank" href="{{$emailLink}}" class="redesSociais__icon">
                    <img src="{{asset('storage/imagens/iconsSite/email.png')}}" width="100%">
                </a>
            </div>
        </div>
    </aside>

    <script>
        const ONLY_HTMLELEMENT=(element)=>document.querySelector(element);
        const ALL_HTMLELEMENT=(element)=>document.querySelectorAll(element);
    </script>
    
    <section class="pagina">
        @yield('content')
    </section>
    
    <a  href="https://wa.me/{{$whatsApp}}" target="_blank" class="whatsApp" >
        <div class="whatsApp__icon">
            <img src="{{asset('storage/imagens/iconsSite/whatsApp.png')}}" 
                width="100%" height="100%">
        </div>
        Me chama no whats agora!!
    </a>

    <script>
        var heartWhite="{{asset('storage/imagens/iconsSite/heartWhite.png')}}";
        var comments="{{asset('storage/imagens/iconsSite/coments.png')}}";
    </script>
    <script src="{{asset('js/scriptTemplateSite.js')}}"></script>
    <script src="{{asset('js/instastory.js')}}"></script>
</body>
</html>