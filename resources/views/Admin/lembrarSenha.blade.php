<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cmsStyle.css') }}">
    
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <style>
        a {
            outline: none !important;
            border: none !important;
            text-decoration: none !important;
            color: black;
        }

         body{
            padding: 0px;
            margin: 0px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height:100vh;
        }
        form{
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

        form input{
            width: 60%;
            color:white;
        }

        .areaVoltarBtn{
            width: 100%;
            display: flex;
            margin-top: 5px;
            position: absolute;
            top: 0px
        }

            
        .voltarPortfolio{
            width: 110px;
            height: 30px;
            line-height: 30px;
            background-color: #004080;
            margin-left: 5px;
            text-align: center;
            font-family: 'ETH';
            cursor: pointer;
            margin-bottom: -30px;
            color: white;
        }

        .voltarPortfolio:hover{
            background-color: white;
            border: 1px solid #004080;
        }
}


    </style>
</head>
<body>
    <div class="areaVoltarBtn">
        <a href="{{route('login')}}">
            <div class="voltarPortfolio">
                Voltar
            </div>
        </a> 
    </div>   

    <form id="formSenha" method="POST" action="{{route('lembrarSenha')}}">
        
        @csrf
        <h3><center>Lembrar Senha</center></h3>
        
        
        <div class="form-group">
            <label><center>Nome</center></label>
            <input class="form-control" name="nome" type="text" id="nome">
        </div>
        
        <div class="form-group">
            <label><center>Email</center></label>
            <input class="form-control" name="email" type="email" id="email">
        </div>

        <center><input  class="btn btn-primary" type="submit"><br><br></center>
        <div class="alert alert-danger" style="display: none;"></div>

        @if($errors->any())
                <div class="alert alert-danger">
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
    
    @if(session('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p>{{session('success')}}</p>
    @endif

</form>
    
</body>

<script>
    
    let form=document.querySelector('#formSenha');
    let alert=document.querySelector('.alert');
    
    form.addEventListener('submit',(event)=>{
        let nome=document.querySelector('#nome').value;
        let email=document.querySelector('#email').value;
        
        if(nome==="" || email===""){
            event.preventDefault();
            alert.style.display="block";
            alert.innerHTML="Preencha todos os campos!";
        }
    })
    
</script>
</html>