<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/siteStyle.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <style>
        

        h1,h2,h3,h4,h5,h6{
            font-family: 'ETH';
        }
        
        body{
            padding: 0px;
            margin: 0px;
            display: flex;
            align-items: center;
            justify-content: center;
            height:100vh;
        }
        form{
            width: 35%;
            height: 70%;
            font-family: 'ETH';
            font-size: 20px;
            padding: 25px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        #formEbookConfirmar{
            width:100% ;
        }
    </style>
</head>
<body>


<form id="formClienteEbook" method="POST" action="{{route('cadastrarClienteEbook')}}">   
    @csrf
    <h3><center>Registre-se para baixar seu arquivo</center></h3> <br><br>   
    
    <input type="hidden" value="{{$idArquivo}}" name="idArquivo">
    
    <div class="form-group">
        <label>Nome</label>
        <input class="form-control" name="nome" type="text" id="nome" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input class="form-control" name="email" type="text" id="email" required>
    </div>

    <div class="form-group">
        <label>Telefone</label>
        <input class="form-control" name="telefone" id="telefone" required>
    </div>

    <center><input class="btn btn-primary" type="submit" value="Confirmar"></center><br><br>
    <div class="alert alert-danger" style="display: none;"></div>

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

@if(isset($clienteDados) && !empty($clienteDados))
<div class="modal fade show" id="modalCliente" style="display: block;" >
    <div class="modal-dialog modal-dialog-centered" role="document" >

        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">
                <h4>Parece que você ja fez um registro com esse email</h4>
                
            </h5>

                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body modal-bodyEvent">
                <form id="formEbookConfirmar" method="POST" 
                        action="{{route('cadastrarClienteEbook')}}">   
                @csrf
                <h5>Confirme os dados</h5><br>
                
                <input type="hidden" value="{{$idArquivo}}" name="idArquivo">
                <input type="hidden" value="true" name="confirmar">
            <input type="hidden" value="{{$clienteDados[0]->idClienteEbook}}" name="idClienteEbook">



                <div class="form-group">
                    <label>Nome Cliente</label>
                    <input class="form-control" type="text" name="nome"
                            id="nomeConfirm" value="{{$clienteDados[0]->nome}}">
                </div>

                <div class="form-group">
                    <label>Email Cliente</label>
                    <input class="form-control" id="emailConfirm" name="email"
                        value="{{$clienteDados[0]->email}}">
                </div>

                <div class="form-group">
                    <label>Telefone</label>
                    <input class="form-control" id="telefoneConfirm" name="telefone" 
                        value="{{$clienteDados[0]->telefone}}">
                </div>
            
            </div>

            <div class="modal-footer">
                <center>
                    <button class="btn btn-danger" id="editConfirm">Editar</button>
                </center>
                <center>
                    <input class="btn btn-success" type="submit" value="Confirmar">
                </center>
            </form> 
            </div>
        </div>
    </div>
</div>  
@endif
<script src="{{asset('js/jquery.maskedinput.js')}}"></script>  

</body>



<script>
    
    let form=document.querySelector('#formClienteEbook');
    let alert=document.querySelector('.alert');
    let modalCliente=document.querySelector('#modalCliente');


    if(modalCliente != null){
        desabilitarInput();
        document.querySelector('#editConfirm').addEventListener('click',(e)=>{
        e.preventDefault();
        habilitarInput();
    })

    }

   
    function desabilitarInput(){
        document.querySelector('#nomeConfirm').setAttribute('readonly','readonly');
        document.querySelector('#emailConfirm').setAttribute('readonly','readonly');
        document.querySelector('#telefoneConfirm').setAttribute('readonly','readonly');;
    }

    function habilitarInput(){
        document.querySelector('#nomeConfirm').removeAttribute('readonly','readonly');;
        document.querySelector('#emailConfirm').removeAttribute('readonly','readonly');;
        document.querySelector('#telefoneConfirm').removeAttribute('readonly','readonly');;
    }

    form.addEventListener('submit',(event)=>{
        let nome=document.querySelector('#nome').value;
        let email=document.querySelector('#email').value;
        let telefone=document.querySelector('#telefone').value;
        
        if(nome==="" || email==="" || telefone===""){
            event.preventDefault();
            alert.style.display="block";
            alert.innerHTML="Preencha todos os campos!";
        }
    })

    jQuery(function($){
                $("#telefone").mask("(99)99999-9999",{completed:function(){
                    $("#telefone").val="";
                }});
            });
           
    
</script>
</html>