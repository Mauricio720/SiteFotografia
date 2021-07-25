@extends('layouts.templateCMS')

@section('content')
    <section class="usuarioPage">
        <div class="containerUsuario">
            @if (in_array("ADM",$permissoes) || 
                    in_array("Adm Segundario",$permissoes))
            <div class="barraUserAdm">
                <div class="containerBarraUserAdm">
                    <div class="opcaoBarraUser opcaoBarraUserSelected">Meu Perfil</div>
                    <a class="opcaoBarraUser" href="{{route('usuariosPainel')}}">
                        <div class="opcaoBarraUser">Usuarios</div>
                    </a>
                </div>
            </div><br>
            @endif
            
            
            <div class="areaPerfil">
                <form method="POST" action="{{route('editarUsuario')}}" 
                    id="formPerfil" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="idUsuario" value="{{$dadosUser->idUsuario}}">
                    <input type="hidden" id="emailAlterado" name="emailAlterado" value="">


                    <div class="fotoPerfilArea">
                        <div class="fotoPerfil">
                            <img src="{{asset('storage/imagens/fotoPerfil/'.$dadosUser->fotoPerfil)}}" width="100%" height="100%">
                        </div>
                    </div>
                    
                    <input type="file" name="fotoPerfil" id="fotoPerfil">
                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" name="nome" 
                        type="text" value="{{$dadosUser->nome}}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" id="emailCampo"
                             name="email" type="email" value="{{$dadosUser->email}}" required>
                    </div>

                    <div class="form-group">
                        <label>Senha</label>
                        <input class="form-control" name="senha" type="password"
                         value="{{$dadosUser->password}}" required>
                    </div>

                    <div class="form-group">
                        <label>Permissões</label>
                        <div class="form-control">
                            {{$dadosUser->permissoes}}
                        </div>    
                    </div>
                    <center><input type="submit" class="btn btn-primary"
                         value="Salvar" style="width: 70%;"></center>
                        <br>
                        
                        @if($errors->any())
                            <div class="alert alert-danger"  id="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        
                            @foreach ($errors->all() as $error)
                                <ul>
                                    <li>{{$error}}</li>
                                </ul>    
                                <script>
                                    alert =document.querySelector("#alert");
                                    alert.scrollIntoView();
                                </script>
                            @endforeach
                        </div>
                        @endif    
                </form>
            </div>
        </div>


        <div class="modal" id="modalConfirmEmail">
            <div class="modal-dialog">
              <div class="modal-content">
          
                <div class="modal-header">
                <h4 class="modal-title">Email foi alterado</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
          
                <div class="modal-body">
                    <div class="form-group">
                        <label style="font-family: 'ETH';">Digite o codigo enviado no novo Email</label>
                        <input class="form-control" id="campoCodigo" type="text">
                        <div class="alert alert-danger"  id="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>   
                    </div>
                </div>
          
                <div class="modal-footer">
                    <button type="button" id="btnSalvar" class="btn btn-danger"> Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalConfirmEmail">
            <div class="modal-dialog">
              <div class="modal-content">
          
                <div class="modal-header">
                <h4 class="modal-title">Email foi alterado</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
          
                <div class="modal-body">
                    <div class="form-group">
                        <label >Digite o codigo enviado no novo Email</label>
                        <input class="form-control" id="campoCodigo" type="text">
                        <div class="alert alert-danger"  id="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>   
                    </div>
                </div>
          
                <div class="modal-footer">
                    <button type="button" id="btnSalvar" class="btn btn-danger"> Confirmar</button>
                </div>
            </div>
        </div>
    </div>

        <script>
            var urlEmail="{{route('enviarEmailConfirmacao')}}";
            var token="{{ csrf_token() }}";
        </script>
    </section>
    <script src="{{asset('js/scriptMeuPerfilCms.js')}}"></script>
@endsection
