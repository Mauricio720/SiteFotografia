@extends('layouts.templateCMS')
<!DOCTYPE html>
<html lang="en">
<head>
    @if($artigo->aprovado)
        <link rel="stylesheet" href={{ asset('css/blogContent.css')}}>
    @else
        <link rel="stylesheet" href="{{asset('css/editor.css')}}">
    @endif

</head>
<body>
@section('content')
<section class="verArtigoPage">
    <div class="areaVoltarBtn">
        <a href="{{route('artigosPainel')}}">
            <div class="voltarPortfolio">
                Voltar
            </div>
        </a> 
        @if($artigo->aprovado && $artigo->idUsuario == $user->idUsuario)
            <div class="voltarPortfolio" id="btnEdicao" style="width:150px; margin-left: 5px; color:white">
                Modo Edição
            </div>
        @endif
    </div> 
    @if($artigo->aprovado || $artigo->idUsuario!=Auth::user()->idUsuario)
    <div class="containerVisualizaçãoArtigo"><br><br>
        <div class='verArtigoPage'>
            <div class="containerVerArtigo">
                <div class="bannerArtigo" style="background-image: 
                    url('{{asset('storage/'.$artigo->fotoCapa)}}'); width:95%;">
                      <div class="areaInfoArtigo bannerInfoArtigo">
                                <center><h3 style="color: white;">{{$artigo->tituloArtigo}}</h3></center>
    
                                <div class="descricaoArtigo bannerArtigoDescricao">
                                    {{$artigo->descricaoArtigo}}
                                </div>
                            </div>
                        </div> 
                
                <div class="conteudoArtigo">
                    {!!$artigo->html!!}
                </div><br>
    
                <div class="areaAutor">
                    <label>Autor:</label>
                    <div class="autor">
                        {{$artigo->autor}}
                    </div>
                </div>
                
            @if(count($arquivosArtigos)>0)
            <div class="containerAreaArquivos">
                <div class="areaArquivos">
                    @foreach ($arquivosArtigos as $arquivo)
                    <a class="arquivos" href="{{route('baixarArquivoArtigo',
                    ['slugArtigo'=>$artigo->slug,'nomeArquivo'=>$arquivo->nomeArquivo])}}">
                            {{$arquivo->descricaoLink}}</a><br>   
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

   
    
    @elseif($artigo->idUsuario==Auth::user()->idUsuario && $artigo->aprovado==false || in_array('ADM',$permissoes)) 
    <br><br>
    <div class="areaCriacaoArtigo">
       
        <form method="post" enctype="multipart/form-data" id="formUpload"></form>

        <div class="editorModal">
            <div class="editorModal__header">
                <span class="close editorModal__close">X</span>
            </div>
            <div class="editor"></div>
        </div>
    
        <div class="blockStyle blockStyle--style1">
            <span class="blockStyle__close close">X</span>
            
            <div class="blockStyle__blockContent htmlSlot">
                <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
            </div>
        </div>
    
        <div class="blockStyle blockStyle--style2">
            <span class="blockStyle__close close">X</span>
            <div class="blockStyle__blockContent htmlSlot">
                <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
            </div>
            <div class="blockStyle__blockContent blockStyle__blockContent--image">
                <div class="blockContent--image__header">
                    <div class="blockContent--image__header--slot leftImage"><</div>
                    <div class="blockContent--image__header--slot increaseImage">+</div>
                    <div class="blockContent--image__header--slot centerImage">...</div>
                    <div class="blockContent--image__header--slot decreaseImage">-</div>
                    <div class="blockContent--image__header--slot rightImage">></div>
                </div>
                <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
            </div>
        </div>
    
        <div class="blockStyle blockStyle--style3">
            <span class="blockStyle__close close">X</span>
            <div class="blockStyle__blockContent blockStyle__blockContent--image">
                <div class="blockContent--image__header">
                    <div class="blockContent--image__header--slot leftImage"><</div>
                    <div class="blockContent--image__header--slot increaseImage">+</div>
                    <div class="blockContent--image__header--slot centerImage">...</div>
                    <div class="blockContent--image__header--slot decreaseImage">-</div>
                    <div class="blockContent--image__header--slot rightImage">></div>
                </div>
                <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
            </div>    
        
            <div class="blockStyle__blockContent htmlSlot">
                <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
            </div>
                
        </div>
    
        <div class="blockStyle blockStyle--style4">
            <span class="blockStyle__close close">X</span>
            <div class="blockStyle__content-group">
                <div class="blockStyle__blockContent blockStyle__blockContent--image">
                    <div class="blockContent--image__header">
                        <div class="blockContent--image__header--slot leftImage"><</div>
                        <div class="blockContent--image__header--slot increaseImage">+</div>
                        <div class="blockContent--image__header--slot centerImage">...</div>
                        <div class="blockContent--image__header--slot decreaseImage">-</div>
                        <div class="blockContent--image__header--slot rightImage">></div>
                    </div>
                    <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                    <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
                </div>    
            
                <div class="blockStyle__blockContent htmlSlot">
                    <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                    <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
                </div>
            </div>
            <div class="blockStyle__content-group">
                <div class="blockStyle__blockContent htmlSlot">
                    <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                    <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
                </div>
            </div>
        </div>
    
        <div class="blockStyle blockStyle--style5">
            <span class="blockStyle__close close">X</span>
            <div class="blockStyle__content-group">
                <div class="blockStyle__blockContent htmlSlot">
                    <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                    <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
                </div>
            </div>
            
            <div class="blockStyle__content-group blockStyle__content-group--imagesGrid">
                <div class="blockStyle__blockContent blockStyle__blockContent--image">
                    <div class="blockContent--image__header">
                        <div class="blockContent--image__header--slot leftImage"><</div>
                        <div class="blockContent--image__header--slot increaseImage">+</div>
                        <div class="blockContent--image__header--slot centerImage">...</div>
                        <div class="blockContent--image__header--slot decreaseImage">-</div>
                        <div class="blockContent--image__header--slot rightImage">></div>
                    </div>
                    <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                    <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
                </div> 
    
                <div class="blockStyle__blockContent blockStyle__blockContent--image">
                    <div class="blockContent--image__header">
                        <div class="blockContent--image__header--slot leftImage"><</div>
                        <div class="blockContent--image__header--slot increaseImage">+</div>
                        <div class="blockContent--image__header--slot centerImage">...</div>
                        <div class="blockContent--image__header--slot decreaseImage">-</div>
                        <div class="blockContent--image__header--slot rightImage">></div>
                    </div>
                    <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                    <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
                </div> 
    
                 
            </div>
           
        </div>
        
        <div class="blockStyle blockStyle--style6">
            <span class="blockStyle__close close">X</span>
            <div class="blockStyle__content-group">
                <div class="blockStyle__blockContent htmlSlot">
                    <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                    <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
                </div>
                <div class="blockStyle__blockContent blockStyle__blockContent--image">
                    <div class="blockContent--image__header">
                        <div class="blockContent--image__header--slot leftImage"><</div>
                        <div class="blockContent--image__header--slot increaseImage">+</div>
                        <div class="blockContent--image__header--slot centerImage">...</div>
                        <div class="blockContent--image__header--slot decreaseImage">-</div>
                        <div class="blockContent--image__header--slot rightImage">></div>
                    </div>
                    <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                    <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
                </div>    
            </div>
            <div class="blockStyle__content-group">
                <div class="blockStyle__blockContent htmlSlot">
                    <button class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>
                    <button class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>
                </div>
            </div>
        </div>


        
        <div class="blockStyle blockStyle--style7">
            <span class="blockStyle__close close">X</span>
            <div class="blockStyle__content-group">
                <div class="blockStyle__blockContent blockStyle__blockContent--image">
                    <div class="blockContent--image__header">
                        <div class="blockContent--image__header--slot leftImage"><</div>
                        <div class="blockContent--image__header--slot increaseImage">+</div>
                        <div class="blockContent--image__header--slot centerImage">...</div>
                        <div class="blockContent--image__header--slot decreaseImage">-</div>
                        <div class="blockContent--image__header--slot rightImage">></div>
                    </div>
                    <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                    <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
                </div>    

                <div class="blockStyle__blockContent blockStyle__blockContent--image">
                    <div class="blockContent--image__header">
                        <div class="blockContent--image__header--slot leftImage"><</div>
                        <div class="blockContent--image__header--slot increaseImage">+</div>
                        <div class="blockContent--image__header--slot centerImage">...</div>
                        <div class="blockContent--image__header--slot decreaseImage">-</div>
                        <div class="blockContent--image__header--slot rightImage">></div>
                    </div>
                    <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" class="blockStyle__image" default>
                    <input type="file" class="blockStyle__blockContent--imageFile" name="file" style="display: none;">
                </div>  
            </div>
        </div>

        <div class="editorBlog-header">
            <div class="editorBlog-header__content">
                <div class="editorBlog__slot" id="editorBlog__style1">
                    <img src="{{asset('storage/imagens/iconsSite/blockEditor1.jpeg')}}" 
                        width="95%" height="90%">    
                </div> 
                <div class="editorBlog__slot" id="editorBlog__style2">
                    <img src="{{asset('storage/imagens/iconsSite/blockEditor2.jpeg')}}" 
                        width="95%" height="90%"> 
                </div> 
                <div class="editorBlog__slot" id="editorBlog__style3">
                    <img src="{{asset('storage/imagens/iconsSite/blockEditor3.jpeg')}}" 
                        width="95%" height="90%">     
                </div> 
                <div class="editorBlog__slot" id="editorBlog__style4">
                    <img src="{{asset('storage/imagens/iconsSite/blockEditor4.jpeg')}}" 
                        width="95%" height="90%">     
                </div> 
                <div class="editorBlog__slot" id="editorBlog__style5">
                    <img src="{{asset('storage/imagens/iconsSite/blockEditor5.jpeg')}}" 
                        width="95%" height="90%">     
                </div> 
                <div class="editorBlog__slot" id="editorBlog__style6">
                    <img src="{{asset('storage/imagens/iconsSite/blockEditor6.jpeg')}}" 
                        width="95%" height="90%">     
                </div> 
                <div class="editorBlog__slot" id="editorBlog__style7">
                    <img src="{{asset('storage/imagens/iconsSite/blockEditor7.jpeg')}}" 
                        width="95%" height="90%">     
                </div> 
            </div>
        </div>
        
        <div class="editorBlog editor-w-100" id="editorBlog">
           
            @if($artigo->htmlEdit=="")
                    <center><h2>Modo Edição</h2></center>
                @endif
            <div id="editorBlog__content">
                @if($artigo->aprovado==false)
                    {!!$artigo->htmlEdit!!}
                @endif
              
            </div>
            <form method="POST" action="{{route('atualizarHtmlArtigo')}}"
                style="font-family:'ETH'; width:95%;" id="formEditorHtml">
                @csrf

                <input type="hidden" name="idArtigo" value="{{$artigo->idArtigo}}">

                <input type="hidden" id="html" name="html">
                <input type="hidden" id="htmlEditor" name="htmlEditor">
                <center><input class="btn btn-primary" type="submit"
                value="Salvar" id="btnSubmit" style="width: 186px;"></center>
        </form><br>
        </div>
    
        <div class="btnEditor">...</div>

        <center><h4>Arquivos adicionais do artigo</h4></center>
        <div class="areaArquivos">
            <table class="table table-bordered table-hover table-condensed" width="100" height="100">
                <thead>
                    <th></th>
                    <th>Nome Arquivo</th>
                    <th>Descricao Link</th>
                    <th>Artigo</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($arquivosArtigos as $arquivos)
                       <tr>
                            <td>
                                <center>
                                    <div class='iconArquivo'>
                                        <img src="{{asset('storage/imagens/iconsSite/files.png')}}"
                                            width="100%" height="100%">

                                    </div>
                                </center>
                            </td>
                            <td>{{$arquivos->nomeArquivo}}</td>
                            <td>{{$arquivos->descricaoLink}}</td>
                            
                            <td>{{$arquivos->tituloArtigo}}</td>
                            <td>
                                <div class="btn btn-primary"  data-toggle="modal" 
                                    data-target="#modalEditarArquivo{{$arquivos->idArquivoArtigo}}">Editar</div>
                                <a class="btn btn-danger btnExcluirArquivo"
                                    href="{{route('excluirArquivosArtigos',
                                    ['idArquivoArtigo'=>$arquivos->idArquivoArtigo])}}">
                                    Excluir
                                </a> 
                                
                                <a  class="btn btn-success" href="{{route('baixarArquivoArtigo',
                                    ['slugArtigo'=>$artigo->slug,'nomeArquivo'=>$arquivos->nomeArquivo])}}">
                                    Baixar
                                </a>
                            </td>
                        </tr> 
                        
                        <div class="modal fade" id="modalEditarArquivo{{$arquivos->idArquivoArtigo}}"
                                 style="z-index:20000;">

                            <div class="modal-dialog modal-dialog-centered" >
                        
                                <div class="modal-content">
                        
                                        <div class="modal-header">
                        
                                            <h5 class="modal-title">
                        
                                                Info Arquivo Editar
                        
                                            </h5>
                        
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        
                                                <span aria-hidden="true">&times;</span>
                        
                                            </button>
                        
                                        </div>
                        
                                    <div class="modal-body">
                        
                                        <form method="POST" action="{{route('editarArquivoArtigo')}}"
                                             enctype="multipart/form-data">
                        
                                            @csrf
                                            <input type="hidden" name="idArtigo" value="{{$artigo->idArtigo}}">
                                            <input type="hidden" name="idArquivoArtigo" value="{{$arquivos->idArquivoArtigo}}">

                                            <div class="form-group">
                                                <label>Escolha o arquivo complementar para o artigo</label>
                                                <input  type="file" name="arquivoArtigo" id="fotoArtigoFile">
                                            </div><br>
                        
                                            <div class="form-group">
                                                <label>Descrição para o link</label>
                                                <input class="form-control"
                                                     type="text" name="descricaoLink" 
                                                     placeholder="Ex: Baixe aqui meu ebook"
                                                     required
                                                     value="{{$arquivos->descricaoLink}}">
                                            </div>
                        
                                           
                                            <center><input type="submit" class="btn btn-primary"
                                                     value="Salvar" style="width: 300px;"></center>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    
                @endforeach


                </tbody>
            </table> 
            
            <div class="areaAddArquivo">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" 
                        title="Adicionar Arquivo">

                    <div class="addArquivo" data-toggle="modal" data-target="#modalAddArquivo">
                        +
                    </div>
                </span>
            </div> <br><br><br>
        </div>
        
        @if($artigo->idUsuario==Auth::user()->idUsuario
        || in_array('ADM',$permissoes) 
            || in_array('Adm Segundario',$permissoes))
            <center><h5>Observação do Artigo</h5></center>
            <div class="areaObservacao">
                {{$artigo->observacao}}
            </div>
        @endif    
    <br>
        

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
            <script>
                alert =document.querySelector(".alert");
                alert.scrollIntoView();
            </script>
        </div>
        </div><br>
        
    @endif

@endif

<div class="modal fade" id="modalAddArquivo" style="z-index:20000;">

    <div class="modal-dialog modal-dialog-centered" >

        <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Info Arquivo

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

            <div class="modal-body">

                <form method="POST" action="{{route('cadastrarArquivoArtigo')}}"
                     enctype="multipart/form-data">

                    @csrf
                    <input type="hidden" name="idArtigo" value="{{$artigo->idArtigo}}">
                    
                    <div class="form-group">
                        <label>Escolha o arquivo complementar para o artigo</label>
                        <input  type="file" name="arquivoArtigo" id="fotoArtigoFile">
                    </div><br>

                    <div class="form-group">
                        <label>Descrição para o link</label>
                        <input class="form-control"
                             type="text" name="descricaoLink" placeholder="Ex: Baixe aqui meu ebook"
                             required>
                    </div>

                   
                    <center><input type="submit" class="btn btn-primary"
                             value="Salvar" style="width: 300px;"></center>
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
</section>
</body>
<script>
    var rotaEditorUpload="{{route('imageUploadEditor',['idArtigo'=>$artigo->idArtigo])}}";
</script>
<script src="{{asset('js/editor.js')}}"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




<script>
    let excluirArquivo=ALL_HTMLELEMENT('.btnExcluirArquivo');
    [...excluirArquivo].map((item)=>{
        item.addEventListener('click',(event)=>{
            event.preventDefault();
            let modal=ONLY_HTMLELEMENT('#modalConfirmacao');
            modal.style.display="block";
            modal.querySelector('.modal-title').innerHTML="Tem Certeza que deseja excluir esse arquivo do artigo?";
            modal.querySelector('.alert').innerHTML="Esse arquivo será deletado e não podera ser baixado no site principal!";
            
            modal.querySelector('#confirmarModal').addEventListener('click',(e)=>{
                window.location = item.href; 
            })
        
        })
    });
    if(ONLY_HTMLELEMENT('#btnEdicao') != null){
        ONLY_HTMLELEMENT('#btnEdicao').addEventListener('click',(event)=>{
                event.preventDefault();
                $.ajax({
                    url: '{{route('atualizarStatusArtigo')}}', 
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },      
                    data: {'aprovado':0,'idArtigo':'{{$artigo->idArtigo}}'},
                    error:(error)=>{
                        alert('algo deu errado'+error);
                    }  
                });
    
                window.location =  window.location;
            });
        }

</script>


</div>
</html>   
@endsection