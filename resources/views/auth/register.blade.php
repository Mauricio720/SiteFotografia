@extends('layouts.templateCMS')
@section('content')
    <section class="usuarioPage">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <label for="">Nome</label><br>
            <input type="text" name="nome"><br><br>

            <label for="">Email</label><br>
            <input type="text" name="email"><br><br>

            <label for="">Senha</label><br>
            <input type="password" name="senha"><br><br>

            <label for="">Permissão</label><br>
            <select name="permissao" id="">
                <option value="1">Adm</option>
                <option value="2">Fotos</option>
                <option value="3">Artigos</option>
            </select><br><br>

            <input type="submit" value="cadastrar">
        </form>
        
        @if($errors->any())
            @foreach ($errors->all() as $error)
                {{$error}}    
            </section><br>
            @endforeach
        @endif
    </div>
@endsection
   

