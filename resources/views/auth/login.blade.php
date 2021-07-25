<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/cmsStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>

<div class="containerLogin">    
    <div class="logoLoginArea">
        <div class="logoLoginP1">
            <img src="{{asset("storage/imagens/iconsSite/logoMobile.png")}}"
            width="60%" height="100%"> 
        </div>

        <div class="logoLoginP2">
            CMS 
        </div>
    </div>
    <form method="POST" action="{{route('login')}}" id="formLogin">
        @csrf
        <div class="form-group">
            <div class="form-control">
                <div class="iconCampo">
                    <img src="{{asset('storage/imagens/iconsSite/email.png')}}" width="100%" height="100%">
                </div>
                <input placeholder="Email" type="email" name="email">
            </div>
            
        </div><br><br>
        
        <div class="form-group">
            <div class="form-control">
                <div class="iconCampo">
                    <img src="{{asset('storage/imagens/iconsSite/senha.png')}}" width="100%" height="100%">
                </div>
                <input  placeholder="Senha"  type="password" name="password">
             </div>    
        </div><br><br>
        <input type="submit" value="Entrar" class="btn btn-success" 
            style="cursor: pointer; width:50%;"><br>
        <a class="btn btn-warning" href="{{route('lembrarSenha')}}" 
            style="cursor: pointer; width:50%;">Esqueci a senha.</a>

    </form><br>
    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            
            {{$error}}
        </div>   
            
    </div><br>
    @endforeach
@endif

</div>

   
</body>
</html>    