@extends('layouts.templateCMS')
<?php 
    $permissoes=explode("/",$user->permissoes);
?>
@section('content')
    <div class="containerBarraArtigo">
        <div class="barraArtigo">
            <a href="{{route('artigosPainel')}}" class="opcaoBarraArtigo">Todos Artigos</a>
            <div class="opcaoBarraArtigo barraArtigoSelected">Meus Artigos</div>
        </div>
    </div>
    <section class="artigosPage">
        <div class="containerArtigos">
            <form id="formPesquisa" method="POST" action="{{route('pesquisarArtigoPorUsuario')}}">
                @csrf
                <div class="form-group" style="margin-top:14px;">
                    <input class="form-control" type="text" name="tituloDescricao" 
                        placeholder="Titulo ou descrição artigo" value="{{$tituloDescricao}}">
                </div>
                <input type="submit" value="pesquisar" class="btn btn-primary">
            </form>
            
            @foreach ($dadosArtigo as $artigos)
            <div class="artigo" style="background-image: 
                url({{asset('storage/'.$artigos['fotoCapa'])}})">
            <div class="areaAcoes">
                @if($artigos->idUsuario==Auth::user()->idUsuario
                        || in_array('ADM',$permissoes) 
                            || in_array('Adm Segundario',$permissoes))
                            <div class="areaBtnAcoes">
                                <a href="{{route('excluirArtigo',['idArtigo'=>$artigos['idArtigo']])}}"
                                    class="btnArtigo btnExcluirArtigo">
                                    <img src="{{asset('storage/imagens/iconsSite/trash.png')}}"
                                            width="100%" height="100%">
                                </a>

                                @if($artigos->idUsuario == $user->idUsuario || in_array('ADM',$permissoes)  )
                                <a  href="{{route('verArtigo',['idArtigo'=>$artigos['idArtigo']])}}"
                                    class="btnArtigo">
                                    <img src="{{asset('storage/imagens/iconsSite/edit.png')}}"
                                            width="100%" height="100%">
                                </a>
                                @endif

                                @if(in_array('ADM',$permissoes))
                               
                                @if($artigos['aprovado']==false)
                                <div class="btnArtigo btnAprovarArtigo" id="{{$artigos['idArtigo']}}">
                                    <img src="{{asset('storage/imagens/iconsSite/visibility.png')}}" 
                                        width="100%" height="100%">
                                </div>
                                
                                @elseif($artigos['aprovado'])    
                                    <div class="btnArtigo btnDesaprovarArtigo" id="{{$artigos['idArtigo']}}">
                                        <img src="{{asset('storage/imagens/iconsSite/not-visibility.png')}}" 
                                            width="100%" height="100%">
                                    </div>
                                @endif
                                
                                @if($artigos['aprovado']==false)
                                <div class="btnArtigo btnObservacao">
                                    <img src="{{asset('storage/imagens/iconsSite/risk.png')}}" 
                                        width="100%" height="100%">
                                </div>
                                @endif

                                <div class="modalObservacao">
                                    <form method="POST" class="formObservacao" action="{{route('atualizarStatusArtigo')}}">
                                        @csrf
                                        <input type="hidden" name="idArtigo" value="{{$artigos->idArtigo}}">

                                        <textarea name="observacao" id="observacao"  cols="30" rows="5">
                                            {!!$artigos->observacao!!}
                                        </textarea>
                                        <div class="form-group" style="display:flex;">
                                            <input class="form-control btn btn-primary" type="submit" value="Salvar">
                                            <button class="form-control btn btn-danger btnObservacaoCancelar">
                                                Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            @endif
                            </div>

                    <div class="infoArtigo">
                        <div class="info">Criado por: {{$artigos['nome']}}</div>
                        <div class="info">Data: {{date('d/m/y',strtotime($artigos['dataCriado']))}}</div>
                        <div class="info">Hora: {{$artigos['horaCriado']}}</div>
                    </div>
                @endif
            </div>
           
            <a class="artigoLink" href="{{route('verArtigoCriacao',
                ['idArtigo'=>$artigos['idArtigo']])}}">
                <center><h3>{{$artigos->tituloArtigo}}</h3></center>
                <div class="descricaoArtigo">
                    {{$artigos['descricaoArtigo']}}
                </div>
            </a>
        </div>
            
        @endforeach

        @if($errors->any())
            
            <div class="alert alert-danger" style="width:60%; z-index:80000;" id="alert">  
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
    
                @foreach ($errors->all() as $error)
                    <ul>
                        <li>{{$error}}</li>
                    </ul>    
                @endforeach
            </div>

            <script>
                alert =document.querySelector(".alert");
                alert.scrollIntoView();
            </script>
        @endif
    
    </div>
        
        <div class="containerAddBtn">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Adicionar Artigo">
                <div class="addArtigo" data-toggle="modal" data-target="#modalAddArtigo">
                        +
                </div>
            </span>
        </div>
        
        <div class="modal fade" id="modalAddArtigo" style="z-index:20000;">

            <div class="modal-dialog modal-dialog-centered" >

                <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">

                                Info Básica Artigo

                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                <span aria-hidden="true">&times;</span>

                            </button>

                        </div>

                    <div class="modal-body">

                        <form method="POST" action="{{route('cadastrarArtigo')}}"
                             enctype="multipart/form-data">

                            @csrf

                            <div class="areaFotoArtigo">

                                <div id="fotoArtigo">
        
                                <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}"
                                     width="100%" height="100%">
                            </div>
                            
                            <input type="file" name="fotoArtigo" id="fotoArtigoFile">
                        </div>

                            <div class="form-group">
                                <label>Título Artigo</label>
                                <input class="form-control"
                                     type="text" name="tituloArtigo" required>
                            </div>

                            <div class="form-group">
                                <label>Descrição Artigo</label>
                                <textarea  class="form-control"
                                    name="descricaoArtigo" cols="30" rows="2">
                                </textarea>   
                            </div>

                            <div class="form-group">
                                <label>Autor Artigo</label>
                                <input class="form-control"
                                    type="text" name="autor" required>   
                            </div>
                             
                            <center><input type="submit" class="btn btn-primary"
                                     value="Salvar" style="width: 40%;"></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modalConfirmacao" style="z-index: 400000;">

            <div class="modal-dialog modal-dialog-centered">

              <div class="modal-content">

          

                <div class="modal-header">

                  <h4 class="modal-title"></h4>

                  <button type="button" class="close closeModal" data-dismiss="modal">&times;</button>

                </div>

          

                <div class="modal-body">

                    <div class="alert alert-danger">

                        

                    </div>

                </div>

          

                <div class="modal-footer">

                    <button class="btn btn-danger" id="confirmarModal">Sim</button>

                    <button type="button" id="btnNao" class="btn btn-primary" data-dismiss="modal">Não</button>

                </div>

            </div>

        </div>

    </div>

       
        <script src="{{asset('js/scriptCmsArtigo.js')}}"></script>
    </section>    
@endsection