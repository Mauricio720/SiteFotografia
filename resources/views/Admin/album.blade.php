@extends('layouts.templateCMS')
@section('content')
    <section class="albumPage">
        <div class="areaVoltarBtn">
            <a href="{{route('portfolioPainel')}}">
                <div class="voltarPortfolio">
                    Voltar
                </div>
            </a> 
        </div> 
        
        <h2>Adicionar Album</h2>

        <form method="POST" action="{{route('addAlbum')}}" id="formAlbum" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idCategoria" value="{{$idCategoria}}">

            <div class="areaFotoAlbum">
                <div id="fotoAlbum">
                    <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" 
                        width="100%" height="100%">
                </div>
            </div>
            
            <input type="file" name="fotoAlbum" id="fotoAlbumFile">
            
            <div class="form-group">
                <label >Ficha Tecnica</label>
                <textarea class="form-control" name="fichaTecnica" 
                    id="fichaTecnica" cols="30" rows="3">
                </textarea>
            </div>

            <div class="form-group">
                <label >Titulo Album</label>
                <input class="form-control" type="text" name="tituloAlbum">
            </div>

            <div class="form-group">
                <label >Descrição Album</label>
                <textarea class="form-control"  name="descricaoAlbum" rows="4">
                </textarea>
            </div>
                
            <div class="form-group">
                <label>Data Evento</label>
                <input class="form-control" type="date" name="dataEvento">
            </div>

            <div class="form-group">
                <label>Slug</label>
                <input class="form-control" type="text" name="slug">
            </div>
            <center>
                <input class="btn btn-primary" type="submit" 
                    value="Salvar" style="width: 40%;"><br><br>
            </center>
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
            </div>
        
            <script>
                alert =document.querySelector("#alert");
                alert.scrollIntoView();
            </script>
        @endif 
    </section>
    
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" 
        referrerpolicy="origin"></script>
    <script src="{{asset('js/scriptCmsAlbum.js')}}"></script>
@endsection    

