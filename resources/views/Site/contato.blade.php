@extends('layouts.templateSite')
<script>var modalAtivo=false;</script>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="{{asset('css/contato.css')}}">
    <title>Orçamento | Fotografo de casamento, São Paulo, Suzano, Poá, Marcos Sousa Fotografia</title>
    <meta name="description" content="Ei Noiva, vamos conversar? Como você imagina o seu casamento ou ensaio? 
        Me conta um pouco sobre como vai ser! Será uma honra contar a história de vocês!">
    <meta property="og:url" content="{{route('contato')}}">
    <meta property="og:title" content="Marcos Sousa">
    <meta property="og:description" content="{{$descricaoSite}}">
    <meta property="og:locale" content="pt_br"> 
    <meta property="og:image" content="{{asset('storage/imagens/configImagens/bannerContact/'.$bannerContact)}}" />
    <meta property="og:type" content="website"/>
</head>
@section('content')

    <div class="banner">
        <img class="parallax" src="{{asset('storage/imagens/configImagens/bannerContact/'.$bannerContact)}}" alt="" class="parallax"> 
    </div>
    <div class="containerContato">
        <h4 class="titulo">Vamos Conversar!?</h4>
        <form class="formContact" method="POST" action="{{route('cadastrarEvento')}}">
            @csrf
            <div class="formContact__ladoEsquerdo">
                <div class="form-group">
                    <label>Me diz seu nome*</label>
                    <input type="text" name="nome" class="form-control" required pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$">
                </div>
                
                <div class="form-group">
                    <label>Que dia vai casar?* </label>
                    <input  type="date" min="{{$dataAtual}}" name="dataEvento" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Deixa seu e-mail aqui*</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <input id="confirmContatoBtn" type="submit" value="Enviar" class="btn-lg btn-primary">
            </div>
            
            <div class="formContact__ladoDireito">
                <div class="form-group">
                    <label>Seu Telefone*</label>
                    <input type="tel" name="telefone" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Me conta mais sobre seu grande dia*</label>
                    <textarea class="form-control" name="descricaoEvento" required rows="3">

                    </textarea> 
                </div>

                <div class="form-group">
                    <label>Onde me encontrou?</label>
                    <select class="form-control" name="comoEncontrou">
                        <option></option>
                        <option value="Facebook">Facebook</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Pinterest">Pinterest</option>
                        <option value="Google">Google</option>
                        <option value="Indicação">Indicação</option>
                    </select>
                </div>

                <input id="confirmContatoMobile" type="submit" value="Enviar" class="btn-lg btn-primary">
            </div>
        </form>
        
        <div class="contato">
            <div class="contato__item">
                <h5 class="contato__subitem contato__subitem--titulo">Marcos Sousa / Contato</h5>
                <div class="contato__subitem contato__subitem--local">SÃO PAULO / SP</div>
            </div>
            <div class="contato__item contato__item--info">
                <h1 style="font-size: 20px;">Orçamento</h1>
            </div>
            <div class="contato__item contato__item--link">
                <a href="{{route('contato')}}" class="contato__btnContato">
                    Vamos conversar!
                </a>
                <div class="contato__subitem" style="text-align: center;">
                    <div style="margin-top: 10px;">
                        {{$emailContato}}
                    </div>
                    <div>
                        {{$numContato}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="instagram">
       
    </div>

    @if (isset($emailJaRegistrado)&& !empty($emailJaRegistrado))
    <script>modalAtivo=true;</script>
    
    <div class="modalContato">
        <div class="modalContato__body">
            <div class="fechar fechar--modal">
                <img src="{{asset('storage/imagens/iconsSite/close.png')}}"  width="100%">
            </div>
            <h5><center>Parece que você ja fez um orçamento com esse email</center></h5>
            <h5>Deseja utilizar os mesmos dados?</h5><br>
            
            <form method="POST" action="{{route('cadastrarEvento')}}" id="formContatoModal">
                @csrf

                <input type="hidden" value="{{$cliente['idCliente']}}" name="idCliente">
                <input type="hidden" value="{{$descricaoEvento}}" name="descricaoEvento">
                <input type="hidden" value="{{$dataEvento}}" name="dataEvento">
                <input type="hidden" value="{{$comoEncontrou}}" name="comoEncontrou">
                
                <div class="form-group">
                    <label>Nome*</label>
                    <input type="text" name="nome" class="form-control" required value="{{$cliente['nome']}}">
                </div>

                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" name="email" class="form-control" required value="{{$cliente['email']}}">
                </div>

                <div class="form-group">
                    <label>Telefone*</label>
                    <input type="text" name="telefone" class="form-control" required value="{{$cliente['telefone']}}">
                </div>

                <div class="form-group">
                    <button class="btn-lg btn-info" style="cursor: pointer;" id="Editar">Editar</button>
                    <input id="confirmar" style="cursor: pointer;" type="submit" value="Confirmar" class="btn-lg btn-primary">
                </div>

            </form>
        </div>
    </div>
    @endif


    @if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" style="font-family:'ETH';">
            {{$error}}    
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        </div><br>

        @endforeach
        <script>
            alert =document.querySelector(".alert-danger");
            alert.scrollIntoView();
        </script>
    @endif

    @if(session('success'))
        <div class="alert alert-success" style="font-family:'ETH';">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        <p>{{session('success')}}</p>
        </div>
        <script>
            alert =document.querySelector(".alert-success");
            alert.scrollIntoView();
        </script>
    @endif

    <script src="{{'js/jquery.maskedinput.js'}}"></script>   
    <script src="{{asset('js/scriptContato.js')}}"></script>
@endsection