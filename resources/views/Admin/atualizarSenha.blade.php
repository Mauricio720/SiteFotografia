<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  user-scalable=no">        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cmsStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <style>
        body{
            padding: 0px;
            margin: 0px;
            display: flex;
            align-items: center;
            justify-content: center;
            height:100vh;
        }
        #formSenha{
            width: 35%;
            height: 70%;
            font-family: 'ETH';
            font-size: 20px;
            background-color: #004080;
            color: white;
            padding: 25px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }
        
        @media (min-width:530px) and (max-width:1000px){
            #formSenha{
                width: 65%;
            }
        }
        
        @media(max-width:530px){
            #formSenha{
                width: 95%;
                height: 80vh;
            }

            .alert-danger{
                font-size: 15px;
                width: 100%;
            }
        }    
    }
    </style>
</head>
<body>


<form id="formSenha" method="POST" action="{{route('atualizarSenha')}}">   
    @csrf
    @if (isset($relembrar) && !empty($relembrar))
        <h3><center>Relembrar Senha</center></h3>    
    @else
        <h3><center>Atualização de Senha</center></h3>
    @endif
    
    
    <input type="hidden" value="{{$idUsuario}}" name="idUsuario">
    <div class="form-group">
        <label>Senha</label>
        <input class="form-control" name="senha" type="password" id="senha">
    </div>

    <div class="form-group">
        <label>Confirmar Senha</label>
        <input class="form-control" name="confirmarSenha" type="password" id="confirmarSenha">
    </div>

    <center><input class="btn btn-primary" type="submit" value="Confirmar"></center><br><br>
    <div class="alert alert-danger" style="display: none;"></div>
</form>
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
</body>

<script>
    
    let form=document.querySelector('#formSenha');
    let alert=document.querySelector('.alert');
    
    form.addEventListener('submit',(event)=>{
        let senha=document.querySelector('#senha').value;
        let confirmarSenha=document.querySelector('#confirmarSenha').value;
        
        if(senha==="" || confirmarSenha===""){
            event.preventDefault();
            alert.style.display="block";
            alert.innerHTML="Preencha todos os campos!";
        }else if(senha!=confirmarSenha){
            event.preventDefault();
            alert.style.display="block";
            alert.innerHTML="A confirmação de senha tem que ser igual a senha!";    
        }
    })
    
</script>
</html>