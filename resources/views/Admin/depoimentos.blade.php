@extends('layouts.templateCMS')
@section('content')
    <section class="containerClientes">
        <div class="barraClientes">
            <div class="containerBarraClientes">
                <a href="{{route('clientesPainel')}}" class="opcaoBarraCliente ">Clientes Orçamento</a>
                <a href="{{route('clientesViewEbook')}}" class="opcaoBarraCliente "> Clientes Arquivos</a>
                <div class="opcaoBarraCliente opcaoBarraClienteSelected"> Clientes Depoimentos</div>
            </div>
        </div> <br><br>
        
        <div class="areaContainerDepoimentos">
        <div id="slideDepoimentos"  class="slide carousel carousel-fade" data-interval="0" data-ride="carousel">
            
            <div class="carousel-inner">
                @foreach ($depoimentos as $key=>$depoimento)
                    @if($key==0)
                        <div class="carousel-item active">
                     @else 
                        <div class="carousel-item">
                     @endif  
                  
                        <form method="POST" action="{{route('editDepoimento')}}" class="formDepoimento">
                            @csrf
                            <input type="hidden" value="{{$depoimento->idDepoimento}}" name="idDepoimento">
                            <div class="areaDeletarDepoimento">
                                <a href="{{route('excluirDepoimento',['idDepoimento'=>$depoimento->idDepoimento])}}" class='iconExcluirDepoimento'>
                                    <img src="{{asset('storage/imagens/iconsSite/trash.png')}}"
                                        width="100%" height="100%">
                                </a>
                            </div>
                            <div class="form-group">
                                <center><label>Depoimento</label></center>
                                <textarea class="form-control" name="depoimento" rows="6" id="depoimentos">
                                    {!!$depoimento->depoimento!!}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <center><label>Nome Cliente</label></center>
                                <input class="form-control" value="{{$depoimento->autor}}" type="text" name="autor">
                            </div>

                            <center><input class="btn btn-primary" type="submit" value="Salvar"></center>
                        </form>
                    </div>
                @endforeach
            </div>     

            <a class="carousel-control-prev" href="#slideDepoimentos" data-slide="prev">

                <span class="carousel-control-prev-icon"
                style="background-image: url({{asset("storage/imagens/iconsSite/return.png")}}) !important;"></span>

            </a>



            <a class="carousel-control-next" href="#slideDepoimentos" data-slide="next">

                <span class="carousel-control-next-icon"
                style="background-image: url({{asset("storage/imagens/iconsSite/next.png")}}) !important;" ></span>

            </a>
        </div>
    </div>
    
    <div class="addDepoimento" data-toggle="modal" data-target="#modalAddDepoimento">
        +
    </div>
    
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

    
</section>

    <div class="modal fade" id="modalAddDepoimento">

        <div class="modal-dialog modal-dialog-centered" >

            <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">

                            Adicionar Depoimento

                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                <div class="modal-body">
                    <form method="POST" action="{{route('addDepoimento')}}">
                        @csrf
                        
                        <div class="form-group">
                            <center><label>Depoimento</label></center>
                            <textarea class="form-control" name="depoimento" rows="6">

                            </textarea>
                        </div>

                        <div class="form-group">
                            <center><label>Nome Cliente</label></center>
                            <input class="form-control" type="text" name="autor">
                        </div>

                        <center><input style="width:40%;" class="btn btn-primary" type="submit" value="Salvar"></center>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalConfirmacao">
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
        let excluirDepoimento=ALL_HTMLELEMENT('.iconExcluirDepoimento');
            [...excluirDepoimento].map((item)=>{
                item.addEventListener('click',(event)=>{
                    event.preventDefault();
                    let modal=ONLY_HTMLELEMENT('#modalConfirmacao');
                    modal.style.display="block";
                    modal.querySelector('.modal-title').innerHTML="Tem Certeza que deseja excluir esse depoimento?";
                    modal.querySelector('.alert').innerHTML="Esse depoimento será tirado do site!";
                    
                    modal.querySelector('#confirmarModal').addEventListener('click',(e)=>{
                        window.location = item.href; 
                    })
                
                })
            });

        ONLY_HTMLELEMENT('.closeModal').addEventListener('click',()=>{
            ONLY_HTMLELEMENT('#modalConfirmacao').style.display="none";
        })

        ONLY_HTMLELEMENT('#btnNao').addEventListener('click',()=>{
            ONLY_HTMLELEMENT('#modalConfirmacao').style.display="none";
        })     

        tinymce.init({
            selector:'#depoimentos',
            width:'100%',
            menubar:false,
            plugins:['link', 'table', 'autoresize', 'lists'],
            toolbar:'undo redo | formatselect | bold italic backcolor | '
                    +'alignleft alignright aligncenter alignjustify | table |'
                    +'link image | bullist numlist | media',
            selector: "textarea",
                    
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
    }        
});
    </script>
@endsection