@extends('layouts.templateCMS')
@section('content')
    <section class="eventosPage">
        <div class="containerEventos">
            <form id="filtragemForm" method="POST"
                 action="{{route('pesquisarPorClienteOuData')}}" style="margin-top: 15px;">
                @csrf
                <div class="form-group">
                    <input class="form-control" placeholder="Nome Cliente" type="text" name="nomeCliente" value="{{$nomeCliente}}">
                </div>
        
                <div class="form-group">
                    
                    <input class="form-control" type="date" name="dataRegistro" value="{{$dataRegistroEvento}}">
                </div>

                <input class="btn btn-primary" type="submit" value="Pesquisar" 
                    style="height: 35px;">
            </form>

            <table class="table table-bordered table-hover table-condensed" id="tableEventos">
                <thead>
                    <th><center>Nome Cliente</center></th>
                    <th><center>Email Cliente</center></th>
                    <th><center>Telefone Cliente</center></th>
                    <th><center>Data Registrado</center></th>
                    <th><center>Hora Registrado</center></th>
                    <th><center>Ações</center></th>
                </thead>
                <tbody>
                    @foreach ($dadosEventos as $evento)
                        <tr>
                            <td>{{$evento->nome}}</td>
                            <td>{{$evento->email}}</td>
                            <td>{{$evento->telefone}}</td>
                            <td>{{date("d/M/Y",strtotime($evento->dataRegistroEvento))}}</td>
                            <td><center>{{date("H:i:s",strtotime($evento->horaRegistroEvento))}}</center></td>
                            <td>
                                <center>
                                    <a href="{{route('marcarDesmarcarEvento',['idEvento'=>$evento->idEvento])}}" class="btn btn-primary">
                                        @if($evento->confirmar)
                                            Desmarcar Lido    
                                        
                                        @else
                                            Marcar Lido    
                                        @endif
                                        </a>
                                   <button class="btn btn-success" data-toggle="modal" 
                                        data-target="#modalEventos{{$evento->idEvento}}">
                                        Ver Mais
                                    </button>
                                </center>
                            </td>
                        </tr>
                        
                        <div class="modal fade" id="modalEventos{{$evento->idEvento}}" >
                            <div class="modal-dialog modal-dialog-centered" role="document" >

                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">
                                        Detalhes do Evento
                                    </h5>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                            <span aria-hidden="true">&times;</span>

                                        </button>

                                    </div>

                                    <div class="modal-body modal-bodyEvent">
                                        <div class="form-group">
                                            <label>Nome Cliente</label>
                                            <div class="form-control">{{$evento->nome}}</div>
                                        </div>

                                        <div class="form-group">
                                            <label>Email Cliente</label>
                                            <div class="form-control">{{$evento->email}}</div>
                                        </div>

                                        <div class="form-group">
                                            <label>Data Evento</label>
                                            <div class="form-control">
                                                {{
                                                    date('d/m/yy',strtotime($evento->dataEvento))
                                                }}
                                            </div>
                                        </div>
                                        
                                        <label>Descrição do Evento</label>
                                        <div class="areaDescricaoEvento">
                                        {{$evento->descricaoEvento}}
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <center>
                                            <button class="btn btn-danger" class="close" 
                                                data-dismiss="modal" aria-label="Close">Fechar</button>
                                            
                                            <a href="{{route('marcarDesmarcarEvento',['idEvento'=>$evento->idEvento])}}" class="btn btn-primary">
                                                @if($evento->confirmar)
                                                    Marcar Não Lido
                                                @else
                                                    Marcar Lido
                                                @endif
                                            </a>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach    
                </tbody>
            </table>
            
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
            @endif 
        </div>
        @if(!empty($dadosEventoNotificacao))
        <div class="modal fade show" id="modalNotificacao" style="display: block">
            <div class="modal-dialog modal-dialog-centered" role="document" >

                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">
                        Detalhes do Evento
                    </h5>

                        <button type="button" class="close" id="closeModal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body modal-bodyEvent">
                        <div class="form-group">
                            <label>Nome Cliente</label>
                            <div class="form-control">{{$dadosEventoNotificacao[0]->nome}} </div>
                        </div>

                        <div class="form-group">
                            <label>Email Cliente</label>
                            <div class="form-control">{{$dadosEventoNotificacao[0]->email}}</div>
                        </div>

                        <div class="form-group">
                            <label>Data Evento</label>
                            <div class="form-control">
                                {{date("d/M/Y",strtotime($dadosEventoNotificacao[0]->dataEvento))}}
                            </div>
                        </div>
                        
                        <label>Descrição do Evento</label>
                        <div class="areaDescricaoEvento">
                            {{$dadosEventoNotificacao[0]->descricaoEvento}}
                        </div>

                    </div>

                    <div class="modal-footer">
                        <center>
                            <a href="{{route('marcarDesmarcarEvento',['idEvento'=>$dadosEventoNotificacao[0]->idEvento])}}" class="btn btn-primary">
                                @if($dadosEventoNotificacao[0]->confirmar)
                                    Marcar Não Lido
                                    
                                @else
                                    Marcar Lido
                                @endif
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <script>
           if(ONLY_HTMLELEMENT('#modalNotificacao') !=null)
           ONLY_HTMLELEMENT('#modalNotificacao').addEventListener('click',(event)=>{
                let ct=event.currentTarget;

                if(event.target==ct){
                    event.currentTarget.style.display="none";
                }
            });

            if(ONLY_HTMLELEMENT('#closeModal') != null){
                ONLY_HTMLELEMENT('#closeModal').addEventListener('click',(event)=>{
                let ct=event.currentTarget;
            
                ONLY_HTMLELEMENT('#modalNotificacao').style.display="none";
            });
            }
            
        </script>
    </section>
@endsection