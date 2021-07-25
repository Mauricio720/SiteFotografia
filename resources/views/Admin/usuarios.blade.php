@extends('layouts.templateCMS')
@section('content')
    <section class="usuarioPage">
        <div class='containerUsers'>
        
        <div class="barraUserAdm">
            <div class="containerBarraUserAdm">
                <a href="{{route('meuPerfilPainel')}}" class="opcaoBarraUser"><div class="opcaoBarraUser">Meu Perfil </div></a>
                <div class="opcaoBarraUser  opcaoBarraUserSelected">Usuarios</div>
            </div>
        </div> <br><br>

        <div class="containerAddBtn">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Adicionar Artigo">
                    <div data-toggle="modal" data-target="#modalAddUser" id="addUsuario">
                            +
                    </div>
            </span>
        </div>
            
       
        <table class="table table-bordered table-hover table-condensed" id="tableUsuario">
            <thead>
                <th></th>
                <th>Nome</th>
                <th>Email</th>
                <th>Permissoes</th>
                <th>Ações</th>
            </thead>
            <tbody>
                @foreach ($dadosUsuarios as $usuario)
                    <tr>
                        <td>
                            <center>
                            <div class="fotoPerfilTabela">
                                <img src="{{asset('storage/imagens/fotoPerfil/'.$usuario->fotoPerfil)}}" 
                                    width="100%" height="100%">
                            </div>
                            </center>
                        </td>
                        <td>{{$usuario->nome}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>{{$usuario->permissoes}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{route('mudarPermissaoView',['usuario'=>$usuario])}}">Mudar Permissão</a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#modalExcluirUser{{$usuario->idUsuario}}">Excluir</button>
                        </td>
                    </tr>

                    
                      
                           
                    <div class="modal fade" id="modalExcluirUser{{$usuario->idUsuario}}" >

                        <div class="modal-dialog modal-dialog-centered" >
                    
                            <div class="modal-content">
                    
                                    <div class="modal-header">
                    
                                        <h5 class="modal-title">
                    
                                            Tem certeza que dejesa excluir o usuario?
                    
                                        </h5>
                    
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    
                                            <span aria-hidden="true">&times;</span>
                    
                                        </button>
                    
                                    </div>
                    
                                <div class="modal-body">
                    
                                
                                </div>

                                <div class="modal-footer">
                                    <a class="btn btn-danger" href="{{route('deletarUsuario',['idUsuario'=>$usuario->idUsuario])}}">Sim</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>    
        </div>

        @if($errors->any())

        <center><div class="alert alert-danger"  id="alert" style="width: 80%; list-style:none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            
            @foreach ($errors->all() as $error)
                <ul style="list-style: none;">
                    <li>{{$error}}</li>
                </ul>    
            @endforeach
        </div></center>
        <script>
            alert =document.querySelector("#alert");
            alert.scrollIntoView();
        </script>
        
        @endif 

        @if(session('success'))
        <center><div class="alert alert-success" id="alert" style="width: 80%;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        <p>{{session('success')}}</p>
        </div></center>
    @endif

    </section>   

<div class="modal fade" id="modalAddUser" >

    <div class="modal-dialog modal-dialog-centered" >

        <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Adicionar Usuario

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

            <div class="modal-body">

                <form id="formAddUser" method="POST" action="{{ route('cadastrarUsuario') }}">

                    @csrf

                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" type="text" name="nome" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" name="email" required>
                    </div>
                    
                    <label>Permissões</label>
                    <div class="areaPermissoes">
                        <div class="permissoes">
                            <label>Adm Segundario</label>
                            <input  type="checkbox" id="admCheck" name="permissoes[]" value="Adm Segundario">
                        </div>
                        
                        <div class="permissoes">
                            <label>Configurações</label>
                            <input  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Configurações">
                        </div>
                        
                        <div class="permissoes">
                            <label>Fotos</label>
                            <input  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Fotos">
                        </div>
                        
                        <div class="permissoes">
                            <label>Artigos</label>
                            <input  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Artigos">
                        </div>

                        <div class="permissoes">
                            <label>Eventos</label>
                            <input  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Eventos">
                        </div>

                        <div class="permissoes">
                            <label>Clientes</label>
                            <input  type="checkbox" class="permissoesCheck" name="permissoes[]" value="Eventos">
                        </div>
                        <hr>
                    </div>

                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Salvar">
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>








<script src="{{asset('js/scriptCmsUsuarios.js')}}"></script>
@endsection 