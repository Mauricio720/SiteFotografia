<!DOCTYPE html>

<html>

    <head>
        
        <title>Gerenciador Fotografia</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="{{ asset('css/cmsStyle.css') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

        <link rel="icon" type="imagem/png" href="{{asset("storage/imagens/iconsSite/logoIcon.jpeg")}}" />

        <script src="{{ asset('js/jquery.min.js') }}"></script>

        <script src="{{ asset('js/jquery.mask.js') }}"></script>

        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" 
        referrerpolicy="origin"></script>

    </head> 
<body>
    <?php 
        $permissoes=explode("/",$user->permissoes);
    ?>

<div class="load">
    <img src="{{asset('storage/imagens/iconsSite/loading.gif')}}" width="5%" height="10%">
</div>

<div class="bigContainer">
        
        <aside class="menu">

            <div class="menuArea">

                <div class="menuOpen">

                        <div class="lineMenu"></div>

                        <div class="lineMenu"></div>

                        <div class="lineMenu"></div>

                    </div>

                </div>

            <nav>

                <ul>
                    @if (in_array("ADM",$permissoes) || 
                                in_array("Adm Segundario",$permissoes) ||
                                    in_array("Configurações",$permissoes))

                    <a href="{{route('admin')}}">
                        <li> 
                            
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/settings.png')}}"
                                    width="100%" height="100%">
                                @if($selectedMenu=='Home')
                                    <div class="selectedMenu">_</div>
                                @endif
                            </div>
                                Configurações
                        </li>
                    </a>
                    @endif



                    @if (in_array("ADM",$permissoes) || 
                            in_array("Adm Segundario",$permissoes) ||
                                in_array("Fotos",$permissoes))
                    
                    <a href="{{route('portfolioPainel')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/camera.png')}}"
                                    width="90%" height="90%">
                                
                                @if($selectedMenu=='Fotos')
                                    <div class="selectedMenu">_</div>
                                @endif
   
                            </div> 
                            Fotos
                        </li>
                    </a>
                    @endif


                    @if (in_array("ADM",$permissoes) || 
                            in_array("Adm Segundario",$permissoes) ||
                                in_array("Artigos",$permissoes))
                    <a href="{{route('artigosPainel')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/article.png')}}"
                                    width="100%" height="100%">
                                @if($selectedMenu=='Artigos')
                                    <div class="selectedMenu">_</div>
                                @endif   
                            </div> 
                            Artigos
                        </li>
                    </a>
                    @endif

                    @if (in_array("ADM",$permissoes) || 
                            in_array("Adm Segundario",$permissoes) ||
                                in_array("Clientes",$permissoes))
                    <a href="{{route('clientesPainel')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/clientes.png')}}"
                                    width="100%" height="90%">
                                
                                @if($selectedMenu=='Clientes')
                                    <div class="selectedMenu">_</div>
                                @endif   
                            </div>
                             Clientes
                        </li>
                    </a>
                    @endif

                    @if (in_array("ADM",$permissoes) || 
                            in_array("Adm Segundario",$permissoes) ||
                                in_array("Eventos",$permissoes))
                    <a href="{{route('eventosPainel')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/calendar.png')}}"
                                    width="100%" height="100%">
                                @if($selectedMenu=='Eventos')
                                    <div class="selectedMenu">_</div>
                                @endif   
                            </div>
                             Eventos
                        </li>
                    </a>
                    @endif



                    <a href="{{route('meuPerfilPainel')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/user.png')}}"
                                    width="100%" height="100%">
                                @if($selectedMenu=='Usuarios')
                                    <div class="selectedMenu">_</div>
                                @endif   
                            </div>
                             Usuarios
                        </li>
                    </a>

                    @if (in_array("ADM",$permissoes) || 
                            in_array("Adm Segundario",$permissoes))

                    <a href="{{route('seoView')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/seo.png')}}"
                                    width="100%" height="100%">
                                @if($selectedMenu=='SEO')
                                    <div class="selectedMenu">_</div>
                                @endif   
                            </div>
                             SEO
                        </li>
                    </a>
                    @endif

                    @if (in_array("ADM",$permissoes) || 
                            in_array("Adm Segundario",$permissoes) ||
                                in_array("Clientes",$permissoes))
                    <a href="{{route('depoimentosView')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/depoimentos.png')}}"
                                    width="100%" height="90%">
                                
                                @if($selectedMenu=='Clientes')
                                    <div class="selectedMenu">_</div>
                                @endif   
                            </div>
                             Depoimentos
                        </li>
                    </a>
                    @endif

                    <a href="{{route('sair')}}">
                        <li>
                            <div class="iconMenu">
                                <img src="{{asset('storage/imagens/iconsSite/singOut.png')}}"
                                    width="90%" height="90%">
                            </div>
                             Sair
                        </li>
                    </a>
                </ul>
            </nav>
        </aside>

        <script>

            const ONLY_HTMLELEMENT=(element)=>document.querySelector(element);

            const ALL_HTMLELEMENT=(element)=>document.querySelectorAll(element);

        </script>



        <section class="page">
            <header>
                <div class="areaLogo">
                    <div class="logo">
                        <img src="{{asset('storage/imagens/iconsSite/logoMobileWhite.png')}}"
                             width="100%" height="100%">
                    </div>
                </div>

                <div class="areaUser">
                    <div class="areaFotoUser">
                        <div class="fotoUser">
                            <img src="{{asset('storage/imagens/fotoPerfil/'.$user->fotoPerfil)}}">
                        </div>
                    </div>
                    <div class="areaNomePerfil">
                        <div class="nomePerfil">
                            {{$user->nome}}
                        </div>
                    </div>

                    <div class="areaPermissoesMenu">
                        <div class="permissoesMenu">
                            {{$user->permissoes}}
                        </div>
                    </div>
                    <div class="areaNotificacao">
                        
                        @if($numNotificacoesTotal > 0 && in_array('ADM',$permissoes) 
                            || in_array("Adm Segundario",$permissoes))
                            
                            @if(in_array('ADM',$permissoes) && $numNotificacoesTotal==0)
                                <div class="notificacao" id="notificacao">
                            @elseif(in_array('ADM',$permissoes) && $numNotificacoesTotal>0) 
                                <div class="notificacao notificacaoAlerta" id="notificacao">
                            @endif  
                             
                            <?php $notificacaoAdmSeg=$numNotificacoesTotal-$artigosADMNotificacaoNumeros;?>           
                             @if(in_array('Adm Segundario',$permissoes) && $notificacaoAdmSeg<1) 
                                <div class="notificacao" id="notificacao">
                             @elseif(in_array('Adm Segundario',$permissoes) && $notificacaoAdmSeg>0) 
                                <div class="notificacao notificacaoAlerta" id="notificacao">
                             @endif
                             
                            <img src="{{asset('storage/imagens/iconsSite/notificacao.png')}}"
                                    width="90%" height="90%">
                                    @if(in_array('Adm Segundario',$permissoes)
                                        && $numNotificacoesTotal-$artigosADMNotificacaoNumeros>0)
                                        <div class="notificacaoNumero">
                                            {{$numNotificacoesTotal-$artigosADMNotificacaoNumeros}}
                                        </div>
                                    @elseif(in_array('ADM',$permissoes) && $numNotificacoesTotal>0)
                                    <div class="notificacaoNumero">
                                        {{$numNotificacoesTotal}}
                                    </div>    
                                    @endif
                            </div>
                         @elseif($numNotificacoesTotal==0 && $numNotificacoesGeral==0)   
                            <div class="notificacao" id="notificacao">
                                <img src="{{asset('storage/imagens/iconsSite/notificacao.png')}}"
                                    width="90%" height="90%">
                            </div>
                         @else 
                         <?php
                            $numNotificacoesGeralCliente=$numNotificacoesGeral
                                 +$clienteNotificacaoNumeros;

                            $numNotificacoesGeralEventos=$numNotificacoesGeral
                                 +$eventoNotificacaoNumeros;
                                 
                            $numNotificacoesGeralArtigos=$numNotificacoesGeral 
                                +$artigosNotificacaoNumeros
                                
                            ?>
                         
                         <div class="notificacao" id="notificacao">
                            
                         @if(in_array('Clientes',$permissoes) && $numNotificacoesGeralCliente<1) 
                            <div class="notificacao" id="notificacao">
                         @elseif(in_array('Clientes',$permissoes) && $numNotificacoesGeralCliente>0) 
                            <div class="notificacao notificacaoAlerta" id="notificacao">
                        @endif 
                        
                        @if(in_array('Eventos',$permissoes) && $numNotificacoesGeralEventos<1) 
                            <div class="notificacao" id="notificacao">
                        @elseif(in_array('Eventos',$permissoes) && $numNotificacoesGeralEventos>0) 
                            <div class="notificacao notificacaoAlerta" id="notificacao">
                         @endif 
                         
                         @if(in_array('Artigos',$permissoes) && $numNotificacoesGeralArtigos<1) 
                            <div class="notificacao" id="notificacao">
                        @elseif(in_array('Artigos',$permissoes) && $numNotificacoesGeralArtigos>0) 
                            <div class="notificacao notificacaoAlerta" id="notificacao">
                         @endif  
                            <img src="{{asset('storage/imagens/iconsSite/notificacao.png')}}"
                                width="90%" height="90%">
                            
                            
                        @if(in_array("ADM",$permissoes)==false 
                            && in_array("Adm Segundario",$permissoes)==false 
                                && in_array("Eventos",$permissoes))
                                <?php
                                    $numNotificacoesGeral=$numNotificacoesGeral+$eventoNotificacaoNumeros
                                ?>

                                @if($numNotificacoesGeral>0)
                                    <div class="notificacaoNumero">
                                        {{$numNotificacoesGeral}}
                                @endif
                               
                            @endif
                        @if(in_array("ADM",$permissoes)==false 
                                && in_array("Adm Segundario",$permissoes)==false 
                                    && in_array("Clientes",$permissoes))
                                    <?php
                                        $numNotificacoesGeral=$numNotificacoesGeral
                                            +$clienteNotificacaoNumeros
                                    ?>

                                @if($numNotificacoesGeral>0)
                                    <div class="notificacaoNumero">
                                        {{$numNotificacoesGeral}}
                                @endif
                                
                         @endif
                         
                         @if(in_array("ADM",$permissoes)==false 
                                && in_array("Adm Segundario",$permissoes)
                                    || in_array("Artigos",$permissoes))
                                    <?php
                                        $numNotificacoesGeral=$numNotificacoesGeral
                                            +$artigosNotificacaoNumeros
                                    ?>
                                @if($numNotificacoesGeral>0)
                                    <div class="notificacaoNumero">
                                        {{$numNotificacoesGeral}}
                                @endif
                               
                         @endif 
                                
                        </div>
                    </div>      
                    @endif
                </div>
            
                <div class="listaNotificacoes">
                    @if (in_array("ADM",$permissoes) || 
                            in_array("Adm Segundario",$permissoes) ||
                                in_array("Eventos",$permissoes))
                    
                    @foreach ($notificacoesEvento as $notificacao)
                        <a href="{{route('eventosPainelNotificacao',
                            ['idEvento'=>$notificacao['idEvento']])}}">
                            <div class="notificacaoItem">
                                <div class="iconNotificacaoArea">
                                    <div class="iconNotificacao">
                                        <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                            width="100%" height="100%">
                                    </div>
                                </div>
                                    <div class="conteudoNotificacao">
                                        <div class="notificacaoTitulo">
                                            {{$notificacao['tipo']}}
                                        </div>

                                        <div class="notificacaoMsg">
                                            {{$notificacao['msg']}}
                                        </div>
                                    </div>
                            </div>
                        </a>
                    @endforeach  
                    @endif     
                    
                  
                
                @if (in_array("ADM",$permissoes) || 
                        in_array("Adm Segundario",$permissoes) ||
                            in_array("Clientes",$permissoes)) 
                
                @foreach ($notificacoesClientes as $notificacao)
                    <a href="{{route('clientesPainelNotificacao',['idCliente'=>$notificacao['idCliente']])}}">
                        <div class="notificacaoItem">
                            <div class="iconNotificacaoArea">
                                <div class="iconNotificacao">
                                <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                    width="100%" height="100%">
                                </div>
                            </div>
                                <div class="conteudoNotificacao">
                                    <div class="notificacaoTitulo">
                                        {{$notificacao['tipo']}}
                                    </div>

                                    <div class="notificacaoMsg">
                                        {{$notificacao['msg']}}
                                    </div>
                                </div>
                        </div>
                    </a>
                 @endforeach 
            @endif

            @if (in_array("ADM",$permissoes) || 
                in_array("Adm Segundario",$permissoes) ||
                    in_array("Clientes",$permissoes)) 
    
                @foreach ($notificacoesClientesEbook as $notificacao)
                    <a href="{{route('clientesViewEbookNotificacao',
                        ['idClienteEbook'=>$notificacao['idClienteEbook']])}}">
                        <div class="notificacaoItem">
                            <div class="iconNotificacaoArea">
                                <div class="iconNotificacao">
                                <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                    width="100%" height="100%">
                                </div>
                            </div>
                                <div class="conteudoNotificacao">
                                    <div class="notificacaoTitulo">
                                        {{$notificacao['tipo']}}
                                    </div>

                                    <div class="notificacaoMsg">
                                        {{$notificacao['msg']}}
                                    </div>
                                </div>
                        </div>
                    </a>
                @endforeach 
            @endif

            @if (in_array("ADM",$permissoes) || 
                in_array("Adm Segundario",$permissoes) ||
                    in_array("Clientes",$permissoes)) 
    
                @foreach ($notificacoesArquivosClientesEbook as $notificacao)
                    <a href="{{route('clientesViewEbookNotificacao',
                        ['idClienteEbook'=>$notificacao['idClienteEbook'],
                        'idArquivoArtigo'=>$notificacao['idArquivoArtigo']])}}">
                        <div class="notificacaoItem">
                            <div class="iconNotificacaoArea">
                                <div class="iconNotificacao">
                                <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                    width="100%" height="100%">
                                </div>
                            </div>
                                <div class="conteudoNotificacao">
                                    <div class="notificacaoTitulo">
                                        {{$notificacao['tipo']}}
                                    </div>

                                    <div class="notificacaoMsg">
                                        {{$notificacao['msg']}}
                                    </div>
                                </div>
                        </div>
                    </a>
                @endforeach 
            @endif
                
            @if (in_array("ADM",$permissoes) || 
                    in_array("Adm Segundario",$permissoes) ||
                            in_array("Eventos",$permissoes))
                
                @foreach ($lembretesEvento as $lembrete)
                    <a href="{{route('eventosPainelNotificacao',
                        ['idEvento'=>$lembrete['idEvento']])}}">
                    <div class="notificacaoItem">
                        <div class="iconNotificacaoArea">
                            <div class="iconNotificacao">
                                <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                     width="100%" height="100%">
                            </div>
                        </div>
                            <div class="conteudoNotificacao">
                                <div class="notificacaoTitulo">
                                    {{$lembrete['tipo']}}
                                </div>

                                <div class="notificacaoMsg">
                                    {{$lembrete['msg']}}
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach 
                 @endif

            @if (in_array("ADM",$permissoes)) 
              @foreach ($notificacoesArtigosParaAprovar as $notificacao)
               <a href="{{route('verArtigo',
                   ['idArtigo'=>$notificacao['idArtigo']])}}">
               <div class="notificacaoItem">
                   <div class="iconNotificacaoArea">
                       <div class="iconNotificacao">
                           <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                width="100%" height="100%">
                       </div>
                   </div>
                       <div class="conteudoNotificacao">
                           <div class="notificacaoTitulo">
                               {{$notificacao['tipo']}}
                           </div>

                           <div class="notificacaoMsg">
                               {{$notificacao['msg']}}
                           </div>
                       </div>
                   </div>
               </a>
               @endforeach 
            @endif

            @if (in_array("Adm Segundario",$permissoes) ||
                            in_array("Artigos",$permissoes))
              
              @foreach ($notificacoesArtigosAprovados as $notificacao)
               <a href="{{route('verArtigoSite',
                   ['slugArtigo'=>$notificacao['slugArtigo'],'notificacaoArtigo'=>1])}}">
               <div class="notificacaoItem">
                   <div class="iconNotificacaoArea">
                       <div class="iconNotificacao">
                           <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                width="100%" height="100%">
                       </div>
                   </div>
                       <div class="conteudoNotificacao">
                           <div class="notificacaoTitulo">
                               {{$notificacao['tipo']}}
                           </div>

                           <div class="notificacaoMsg">
                               {{$notificacao['msg']}}
                           </div>
                       </div>
                   </div>
               </a>
               @endforeach 
            @endif

            @if (in_array("Adm Segundario",$permissoes) ||
            in_array("Artigos",$permissoes))

                @foreach ($notificacoesArtigosObservacoes as $notificacao)
                <a href="{{route('verArtigoNotificacaoObservacao',
                 ['idArtigo'=>$notificacao['idArtigo']])}}">
                <div class="notificacaoItem">
                <div class="iconNotificacaoArea">
                    <div class="iconNotificacao">
                        <img src="{{asset('storage/imagens/iconsSite/alert-icon.png')}}"
                                width="100%" height="100%">
                    </div>
                </div>
                    <div class="conteudoNotificacao">
                        <div class="notificacaoTitulo">
                            {{$notificacao['tipo']}}
                        </div>

                        <div class="notificacaoMsg">
                            {{$notificacao['msg']}}
                        </div>
                    </div>
                </div>
                </a>
                @endforeach 
            @endif
        </div>
        </header>
            @yield('content')

        </section>

    </div>
    
    <script>
        window.onload = function() {
            ONLY_HTMLELEMENT('.load').style.display="none";
        }
     </script>
    
    <script src="{{asset('js/scriptCmsTemplate.js')}}"></script>

</body>    



</html>   