@extends('layouts.templateCMS')
@section('content')
    <section class="containerClientes">
        <div class="barraClientes">
            <div class="containerBarraClientes">
                <div class="opcaoBarraCliente opcaoBarraClienteSelected">Clientes Orçamento</div>
                <a href="{{route('clientesViewEbook')}}" class="opcaoBarraCliente"> Clientes Arquivos</a>
                <a href="{{route('depoimentosView')}}" class="opcaoBarraCliente"> Clientes Depoimentos</a>
            </div>
        </div> <br><br>

        <form id="filtragemFormCliente" method="POST" action="{{route('clientesPesquisa')}}">
                @csrf
                    <input class="form-control" placeholder="Nome ou Email" 
                        type="text" name="nomeEmailCliente" value="{{$nomeCliente}}">

                <input class="btn btn-primary" type="submit" value="Pesquisar" 
                        style="height: 35px;">
        
            
            </form>

        <table class="table table-bordered table-hover table-condensed" id="tableEventos">
            <thead>
                <th><center>Nome Cliente</center></th>
                <th><center>Email Cliente</center></th>
                <th><center>Telefone Cliente</center></th>
                <th><center>Data Cadastro</center></th>
                <th><center>Hora Cadastro</center></th>
                <th><center>Ações</center></th>
            </thead>
            <tbody>
                @foreach ($dadosClientes as $cliente)
                    <tr>
                        <td>{{$cliente->nome}}</td>
                        <td>{{$cliente->email}}</td>
                        <td>{{$cliente->telefone}}</td>
                        <td>{{date("d/M/Y",strtotime($cliente->dataCadastro))}}</td>
                        <td><center>{{$cliente->horaCadastro}}</center></td>
                        <td>
                            <center>
                                <button class="btn btn-success" data-toggle="modal" 
                                    data-target="#modalClientes{{$cliente->idCliente}}">Ver mais</button>
                               
                            </center>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalClientes{{$cliente->idCliente}}" >
                        <div class="modal-dialog modal-dialog-centered" role="document" >

                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">
                                    Detalhes do Cliente
                                </h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                        <span aria-hidden="true">&times;</span>

                                    </button>

                                </div>

                                <div class="modal-body modal-bodyEvent">
                                    <div class="form-group">
                                        <label>Nome Cliente</label>
                                        <div class="form-control">{{$cliente->nome}}</div>
                                    </div>

                                    <div class="form-group">
                                        <label>Email Cliente</label>
                                        <div class="form-control">{{$cliente->email}}</div>
                                    </div>

                                    <div class="form-group">
                                        <label>Data Cadastro</label>
                                        <div class="form-control">
                                            {{date("d/M/Y",strtotime($cliente->dataCadastro))}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Eventos registrados</label>
                                        <div class="form-control">
                                            {{$cliente->quantidadeEventos}}
                                        </div>
                                    </div>

                                    

                                </div>

                                <div class="modal-footer">
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>
        
        @if(!empty($dadosClientesNotificacao))
        <div class="modal fade show" id="modalCliente" style="display: block;" >
            <div class="modal-dialog modal-dialog-centered" role="document" >

                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">
                        Detalhes do Cliente
                    </h5>

                        <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body modal-bodyEvent">
                        <div class="form-group">
                            <label>Nome Cliente</label>
                            <div class="form-control">{{$dadosClientesNotificacao[0]->nome}}</div>
                        </div>

                        <div class="form-group">
                            <label>Email Cliente</label>
                            <div class="form-control">{{$dadosClientesNotificacao[0]->email}}</div>
                        </div>

                        <div class="form-group">
                            <label>Data Cadastro</label>
                            <div class="form-control">
                                {{date("d/M/Y",strtotime($dadosClientesNotificacao[0]->dataCadastro))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Eventos registrados</label>
                            <div class="form-control">
                                {{$dadosClientesNotificacao[0]->quantidadeEventos}}
                            </div>
                        </div>

                        

                    </div>

                    <div class="modal-footer">
                       
                    </div>
                </div>
            </div>
        </div>
        @endif

        <script>
           if(ONLY_HTMLELEMENT('#modalCliente') != null){
            ONLY_HTMLELEMENT('#modalCliente').addEventListener('click',(event)=>{
                    let ct=event.currentTarget;

                    if(event.target==ct){
                        event.currentTarget.style.display="none";
                    }
                });

                ONLY_HTMLELEMENT('#closeModal').addEventListener('click',(event)=>{
                    let ct=event.currentTarget;

                    ONLY_HTMLELEMENT('#modalCliente').style.display="none";

                });
            }
        </script>
    
    </section>
@endsection