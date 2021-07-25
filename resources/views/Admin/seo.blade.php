@extends('layouts.templateCMS')
@section('content')
    <section class="seoPage">
        <div class="containerSeo">
            <form method="POST" action="{{route('atualizarSeo')}}" enctype="multipart/form-data">
                @csrf 
                <div class="form-group">
                    <center><label>Titulo Site</label></center>
                    <input class="form-control" type="text" name="tituloSite" required
                    value="{{$tituloSite->valor}}">
                </div>   

                <div class="form-group">
                    <center><label>Descrição Site</label></center>
                    <textarea class="form-control" name="descricaoSite" required>
                        {{$descricaoSite->valor}}
                    </textarea>
                </div>
                
                <div class="form-group">
                    <center><label>Site Map</label></center>
                    <input type="file" name="siteMap">
                </div>
                
                    <center><label>Palavras chave</label></center>
                    <div class="containerPalavrasChave">
                    <input id="campoPalavraChave" name="palavrasChave" value="{{$palavrasChave->valor}}">
                        <div class="areaPalavrasChave">
                            @foreach ($palavrasChaveArray as $index=>$palavra)
                            <div class="blocoPalavra" index="{{$index}}">
                                <div class="palavra">
                                    {{$palavra}}
                                </div>
                                <div class="apagar">
                                    X
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="areaInserirPalavraChave">
                            <input type="text" id="palavraChaveInserir" placeholder="Insira a palavra chave.">
                            <button class="btn btn-primary" id="addPalavra">Adicionar</button>
                        </div>
                    </div>  
                    
                    
                    <div class="form-group">
                        <center><input class="btn btn-primary" type="submit" value="Salvar"></center>
                    </div>
                </form>
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

                              
        
    </section>

    <script src="{{asset('js/seoCms.js')}}"></script>
    
@endsection