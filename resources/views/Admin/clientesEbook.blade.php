@extends('layouts.templateCMS')
@section('content')
    <section class="containerClientes">
        <div class="barraClientes">
            <div class="containerBarraClientes">
                <a href="{{route('clientesPainel')}}" class="opcaoBarraCliente ">Clientes Orçamento</a>
                <div  class="opcaoBarraCliente opcaoBarraClienteSelected"> Clientes Arquivos</div>
                <a href="{{route('depoimentosView')}}" class="opcaoBarraCliente"> Clientes Depoimentos</a>
            </div>
        </div> <br><br>

        <form id="filtragemFormCliente" method="POST" action="{{route('clientesPesquisaEbook')}}">
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
                <th><center>Telefone</center></th>
                <th><center>Data Baixado</center></th>
                <th><center>Hora Baixado</center></th>
                <th><center>Arquivo Baixado</center></th>
                <th><center>Ações</center></th>
            </thead>
            <tbody>
                @foreach ($dadosClientes as $cliente)
                    <tr>
                        <td>{{$cliente->nome}}</td>
                        <td>{{$cliente->email}}</td>
                        <td>{{$cliente->telefone}}</td>
                        <td>{{date("d/M/Y",strtotime($cliente->dataBaixado))}}</td>
                        <td><center>{{$cliente->horaBaixado}}</center></td>
                        <td><center>{{$cliente->nomeArquivo}}</center></td>
                        <td>
                            <center>
                                <button class="btn btn-success" data-toggle="modal" 
                                    data-target="#modalClientes{{$cliente->idClienteEbook}}">Ver mais</button>
                               
                            </center>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalClientes{{$cliente->idClienteEbook}}" >
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
                                        <label>Data Arquivo Baixado</label>
                                        <div class="form-control">
                                            {{date("d/M/Y",strtotime($cliente->dataCadastro))}}
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Arquivo Baixado</label>
                                        <div class="form-control">
                                            {{$cliente->nomeArquivo}}
                                        </div>
                                    </div>

                                    

                                </div>

                                <div class="modal-footer">
                                    <form method="POST" action="{{route('clientesPesquisaEbook')}}">
                                        @csrf
                                        <input type="hidden" name="nomeEmailCliente" value="{{$cliente->email}}">
                                        <center>
                                            <input class="btn btn-success" type="submit" value="Ver todos arquivos baixados">
                                           
                                        </center>
                                    </form>
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
                            <div class="form-control">{{$dadosClientesNotificacao->nome}}</div>
                        </div>

                        <div class="form-group">
                            <label>Email Cliente</label>
                            <div class="form-control">{{$dadosClientesNotificacao->email}}</div>
                        </div>

                        <div class="form-group">
                            <label>Data Cadastro</label>
                            <div class="form-control">
                                {{date("d/M/Y",strtotime($dadosClientesNotificacao->dataCadastro))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Data arquivo baixado</label>
                            <div class="form-control">
                                {{date("d/M/Y",strtotime($dadosClientesNotificacao->dataCadastro))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Arquivo Baixado</label>
                            <div class="form-control">
                                {{$dadosClientesNotificacao->nomeArquivo}}
                            </div>
                            
                        </div>
                        

                    </div>

                    <div class="modal-footer">
                        <form method="POST" action="{{route('clientesPesquisaEbook')}}">
                            @csrf
                            <input type="hidden" name="nomeEmailCliente" value="{{$dadosClientesNotificacao->email}}">
                            <center>
                                <input class="btn btn-success" type="submit" value="Ver todos arquivos baixados">
                               
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

       

        <script>
           jQuery(function($){
                $("input[name=telefone]").mask("(99)99999-9999",{completed:function(){
                    $("input[name=telefone]").val="";
                }});
            });
           
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