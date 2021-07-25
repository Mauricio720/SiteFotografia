@extends('layouts.templateCMS')

@section('content')

    <section class="fotosPage">
        <div class="areaVoltarBtn">
            <a href="{{route('portfolioPainel')}}">
                <div class="voltarPortfolio">
                    Voltar
                </div>
            </a> 
        </div> 
        <h2><center>Fotos: {{$tituloAlbum}}</center></h2>

        <div class="containerFotos">

            @forelse ($fotos as $foto)

                <div class="fotos">

                    <div class="areaFotosOpcoes">

                        <div class="areaFotoFavorita">

                            @if ($foto->favorita==1)

                                <a id=favorita class="favorita" 

                                    href="{{route('marcarDesmarcarFoto',

                                        ['idFoto'=>$foto->idFoto,

                                            'idTela'=>2])}}">

                                    <img src="{{asset('storage/imagens/iconsSite/star.png')}}"

                                        width="100%" height="100%">

                                </a>

                            @else

                                <a id=favorita class="favorita"  

                                href="{{route('marcarDesmarcarFoto',

                                    ['idFoto'=>$foto->idFoto,

                                        'idTela'=>2])}}">

                                    <img src="{{asset('storage/imagens/iconsSite/starEmpty.png')}}"

                                        width="100%" height="100%">

                                </a>

                            @endif

                        </div>

                        <div class="areaBtnsMovimentacao">

                            <a class="btnOpcoesFoto excluirFotoBtn"
                                 href="{{route('excluirFoto',

                                ['idFoto'=>$foto->idFoto])}}">

                                <img src="{{asset('storage/imagens/iconsSite/trash.png')}}"

                                    width="100%" height="100%">

                            </a>

                            <div class="btnOpcoesFoto btnInfoAlbum" style="font-size: 25px;">
                                !
                            </div>

                            <div class="infoAlbum">
                                <div class="barraInfo">
                                    <div class="iconInfo">
                                        !
                                    </div>
                                </div>
                                <div class="conteudoInfo">
                                    Adicionada: {{date('d/m/yy',strtotime($foto->dataAdicao))}}<br>
                                    Hora: {{date('H:i:s',strtotime($foto->horaAdicao))}}<br>
                                    Por: {{$foto->nome}}
                                </div>
                            </div>

                        </div>  
                        
                        

                    </div>

                    <img src="{{asset('storage/'.$foto->caminhoFoto)}}"
                     alt="" width="100%">

                </div>        

            @empty

                <h1>Não há fotos nesse album!</h1>

            

            @endforelse

           
            
                
            
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" 

                    title="Adicionar Fotos">

                    <div id="addFoto">
                        +
                    </div>
                </span>

        </div>

        

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

        </div>

        @endif 

    </section>



    <div id="Modal">

        <div class="modalBody">
            <div class="areaCloseAreaFotos">
                <div id="closeAreaFotos">
                    X
                </div>
            </div>
            <form action="{{route('addFoto')}}" method="post" id="formFotos" enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="idAlbum" value="{{$idAlbum}}">

                <div class="areaAddFoto">

                    <div id="escolherFoto">

                        <img src="{{asset('storage/imagens/iconsSite/addImage.png')}}" width="100%" height="100%">

                    </div>

                </div>

                <input type="file" id="fotosFile" name="fotos[]" multiple /><br><br>



                <div class="areaListaFotos">

                    <div class="containerListaFotos">

                        <h4><center>Nenhuma foto selecionada</center></h4>



                        <div class="fotoSelecionada">

                            <img src="" width="100%" height="100%">

                        </div>

                    </div>

                </div>

                <div class="areaBtnEnviarFoto">

                    <input class="btn btn-primary" type="submit" value="Salvar" id="enviarFotos">

                </div>

            </form><br>

            <div class="alert alert-danger" id="alertLimit" style="display: none;">
                O limite de upload é de 60mb
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>
        </div>

    </div>
</div>


    <div class="modal" id="modalConfirmacao">

        <div class="modal-dialog modal-dialog-centered">

          <div class="modal-content">

      

            <div class="modal-header">

              <h4 class="modal-title"></h4>

              <button type="button" class="close closeConfirmacao" data-dismiss="modal">&times;</button>

            </div>

      

            <div class="modal-body">

                

            </div>

      

            <div class="modal-footer">

                <button class="btn btn-danger" id="confirmarModal">Sim</button>

                <button type="button" class="btn btn-primary" id="btnNao">Não</button>

            </div>

        </div>

    </div>

</div>

    <script src="{{asset('js/scriptFoto.js')}}"></script>

@endsection