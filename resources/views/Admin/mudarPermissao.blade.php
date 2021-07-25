@extends('layouts.templateCMS')

@section('content')
    <section class="usuarioPage">
        <div class="containerUsuario">
           
            <h3><center>Mudar Permissao</center></h3>
            
            <div class="areaPerfil">
                <form method="POST" action="{{route('atualizarPermissao')}}" 
                    id="formPerfil" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="idUsuario" value="{{$usuario->idUsuario}}">
                    
                    <div class="fotoPerfilArea">
                        <div class="fotoPerfil" style="cursor: default">
                            <img src="{{asset('storage/imagens/fotoPerfil/'.$usuario->fotoPerfil)}}" width="100%" height="100%">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Nome</label>
                        <div class="form-control">{{$usuario->nome}}</div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <div class="form-control">{{$usuario->email}}</div>
                    </div>

                    <label>Permissões</label>
                    <div class="areaPermissoes" style="height: 160px;">
                        <div class="permissoes">
                            <label>Adm Segundario</label>
                            @if (in_array("Adm Segundario",$permissoes))
                                <input checked  type="checkbox" id="admCheck" name="permissoes[]" value="Adm Segundario">    
                            @else
                                <input type="checkbox" id="admCheck" name="permissoes[]" value="Adm Segundario">    
                            @endif
                            
                        </div>
                        
                        <div class="permissoes">
                            <label>Configurações</label>
                            @if (in_array("Configurações",$permissoes))
                                <input checked  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Configurações">    
                            @else
                                <input type="checkbox" class="permissoesCheck" name="permissoes[]" value="Configurações">     
                            @endif
                            
                        </div>
                        
                        <div class="permissoes">
                            <label>Fotos</label>
                            @if (in_array("Fotos",$permissoes))
                                <input checked  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Fotos">    
                            @else
                                <input type="checkbox" class="permissoesCheck" name="permissoes[]" value="Fotos">     
                            @endif
                        </div>
                        
                        <div class="permissoes">
                            <label>Artigos</label>
                            @if (in_array("Artigos",$permissoes))
                                <input checked  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Artigos">    
                            @else
                                <input type="checkbox" class="permissoesCheck" name="permissoes[]" value="Artigos">     
                            @endif
                        </div>

                        <div class="permissoes">
                            <label>Clientes</label>
                            @if (in_array("Clientes",$permissoes))
                                <input checked  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Clientes">    
                            @else
                                <input type="checkbox" class="permissoesCheck" name="permissoes[]" value="Clientes">     
                            @endif
                        </div>

                        <div class="permissoes">
                            <label>Eventos</label>
                            @if (in_array("Eventos",$permissoes))
                                <input checked  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Eventos">    
                            @else
                                <input type="checkbox" class="permissoesCheck" name="permissoes[]" value="Eventos">     
                            @endif
                        </div>
                    </div><br>
                    <div class="form-group">
                        <center><input type="submit" class="btn btn-primary" value="Salvar"></center>
                    <div class="form-group">
                        
                        @if($errors->any())
                            <div class="alert alert-danger"  id="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        
                            @foreach ($errors->all() as $error)
                                <ul>
                                    <li>{{$error}}</li>
                                </ul>    
                            @endforeach
                        </div>
                        @endif    
                </form>
            </div>
        </div>
    </section>
    <script src="{{asset('js/scriptCmsUsuarios.js')}}"></script>
@endsection
