@extends('layouts.templateCMS')
@section('content')

<section class="PortfolioPage">
    <div class="containerTimeLine" >
        @if(count($category)==0)
            <center><h2>Não há categorias cadastradas</h2></center>
        @else
        
        @foreach ($category as $item)
            <div class="lineTimeArea">
                <div class="areaExcluirCategoria">    
                        <div class="excluirCategoria" data-toggle="modal" 
                                        data-target="#modalExcluirCategoria{{$item->idCategoria}}">
                            <img src="{{asset('storage/imagens/iconsSite/trash.png')}}"
                                    width="100%" height="95%">  
                        </div>  
                    </div>
                <h4>{{$item->nomeCategoria}}</h4>
                    <div class="albumArea" >
                        <a href="{{route('addAlbumView',['idCategoria'=>$item->idCategoria])}}">
                            <div class="addAlbum">
                                +
                            </div>
                        </a>
                        @foreach($albuns as $album)
                            @if($album->idCategoria == $item->idCategoria)
                                <div class="albuns">
                                    <div class="areaAlbumOpcoes">
                                        <a href="{{route('editarAlbumView',
                                            ['idAlbum'=>$album->idAlbum])}}" 
                                            class="btnOpcoesAlbum">
                                            
                                            <img src="{{asset('storage/imagens/iconsSite/edit.png')}}"
                                                    width="95%" height="95%">    
                                        </a>

                                        <a href="{{route('excluirAlbum',
                                                ['idAlbum'=>$album->idAlbum])}}"
                                                 class="btnOpcoesAlbum btnExcluirAlbum">
                                            
                                            <img src="{{asset('storage/imagens/iconsSite/trash.png')}}"
                                                    width="95%" height="95%">          
                                        </a>

                                        <div class="btnOpcoesAlbum btnInfoAlbum">
                                                !
                                        </div>

                                        <div class="infoAlbum">
                                            <div class="barraInfo">
                                                <div class="iconInfo">
                                                        !
                                                </div>
                                            </div>
                                            
                                            <div class="conteudoInfo">
                                                Criado: {{date('d/m/yy',strtotime($album->dataCriacao))}}<br>
                                                Hora: {{date('H:i:s',strtotime($album->horaCriacao))}}<br>
                                                Por: {{$album->nome}}
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{route('fotosAlbum',['idAlbum'=>$album->idAlbum])}}" class="albuns">
                                            <img src="{{ asset("storage/".$album->fotoCapa)}}"
                                             width="100%" height="100%">
                                    </a>
                                    
                                    <a href="{{route('fotosAlbum',['idAlbum'=>$album->idAlbum])}}">
                                    <div class="albumHover">
                                        <div class="verMais">+</div> 
                                            <div class="albumHoverTitle">
                                                {{$album->tituloAlbum}}
                                            </div>
                                        </div>
                                    </a>    
                                </div>
                            @endif
                        @endforeach
                               
                <div class="modal fade" id="modalExcluirCategoria{{$item->idCategoria}}" >
                    <div class="modal-dialog modal-dialog-centered" role="document" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Tem certeza que deseja excluir a categoria?
                                    </h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="alert alert-danger">
                                        Todos os albums e fotos dessa categoria serão excluidos!
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <a href="{{route('excluirCategoria',
                                        ['idCategoria'=>$item->idCategoria])}}" 
                                        class="btn btn-danger">
                                        Sim
                                    </a>

                                     <button class="btn btn-primary" class="close" 
                                        data-dismiss="modal" aria-label="Close">
                                        Não
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
                    
                </div>                           
            </div>
        @endforeach
        @endif 
            <div class="containerAddBtn">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" 
                    title="Adicionar Categoria">
                    <div class="addCategoria" data-toggle="modal" data-target="#modalAddCategoria">
                            +
                    </div>
                </span>
            </div>
            
            <div class="modal fade" id="modalAddCategoria" >
                <div class="modal-dialog modal-dialog-centered" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Nome da Categoria
                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form method="POST" action="{{route('addCategoria')}}">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" type="text" name="nomeCategoria">
                                </div>

                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" value="Salvar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modalConfirmacao">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close closeModal"
                             data-dismiss="modal">&times;
                        </button>
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
    
        @if($errors->any())
            
        <div class="alert alert-danger" style="width:100%; z-index:80000;" id="alert">  
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
            alert =document.querySelector("#alert");
            alert.scrollIntoView();
        </script>
    @endif
    
    </div>
</section>
    
    <script src="{{asset('js/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('js/jquery.mousewheel.min.js')}}"></script>
    <script src="{{asset('js/scriptCmsPortfolio.js')}}"></script>
@endsection