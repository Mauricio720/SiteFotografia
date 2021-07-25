@extends('layouts.templateCMS')

@section('content')
    <section class="verArtigoPage">
        <div class="areaVoltarBtn">
            <a href="{{route('artigosPainel')}}">
                <div class="voltarPortfolio">
                    Voltar
                </div>
            </a> 
        </div> 
        
        @if($artigo->idUsuario == $user->idUsuario || in_array('ADM',$permissoes))
        <div class="containerEdicaoArtigo">
            
        <form method="POST" action="{{route('atualizarArtigo')}}"
            enctype="multipart/form-data" id="formVerArtigo">

           @csrf
           <input type="hidden" name="idArtigo" value="{{$artigo->idArtigo}}">

           <div class="areaFotoArtigo">

               <div id="fotoArtigo">

               <img src="{{asset('storage/'.$artigo->fotoCapa)}}"
                    width="100%" height="100%">
           </div>
           
           <input type="file" name="fotoArtigo" id="fotoArtigoFile">
       </div>

           <div class="form-group">
               <label>Título Artigo</label>
               <input class="form-control"
                    type="text" name="tituloArtigo" value="{{$artigo->tituloArtigo}}" required>
           </div>

           <div class="form-group">
               <label>Descrição Artigo</label>
               <textarea  class="form-control"
                   name="descricaoArtigo" 
                   cols="30" 
                   rows="2">
                   {!!$artigo->descricaoArtigo!!}
            
                </textarea>   
           </div>

           <div class="form-group">
               <label>Autor Artigo</label>
               <input class="form-control"
                   type="text" name="autor" value="{{$artigo->autor}}" required>   
           </div>

           <div class="form-group">
            <label>Slug Artigo</label>
            <input class="form-control"
                type="text" name="slug" value="{{$artigo->slug}}">   
        </div>

           <div class="form-group">
            <label>Tornar visivel esse artigo no CMS</label>
            @if($artigo->publicoCMS)
                <input checked type="checkbox" name="publico">
            @else
                <input type="checkbox" name="publico">
            @endif
        </div><br>
        <center><input class="btn btn-primary" type="submit"
                    value="Salvar" style="width: 50%;"></center>
        </form>
        @if($errors->any())
        <div class="alert alert-danger" style="width:60%;" id="alert">  
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            @foreach ($errors->all() as $error)
                <ul>
                    <li>{{$error}}</li>
                </ul>    
            @endforeach
            <script>
                alert =document.querySelector("#alert");
                alert.scrollIntoView();
            </script>
        @endif
                
    </div>
@endif

    
    </div><br>
        
       

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
    <script>
        var rotaEditorUpload="{{route('imageUploadEditor',['idArtigo'=>$artigo->idArtigo])}}";
    </script>
   
    <script src="{{asset('js/scriptCmsVerArtigo.js')}}"></script>
    </div>
@endsection
