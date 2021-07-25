<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Baixe seu arquivo</title>
    <link rel="stylesheet" href="{{ asset('css/siteStyle.css') }}">
    <link rel="icon" type="imagem/png" href="{{asset("storage/imagens/configImagens/logo/".$logo)}}" />


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
            flex-direction: column;
            height:100vh;
        }

        a{
            font-family: 'ETH';
            font-size: 25px;
            outline: none !important;
            border: none !important;
            color: #004080;
            font-weight: bold;
             
        }

        .areaVoltarBtn{
            width: 100%;
            display: flex;
            margin-top: 5px;
            position: absolute;
            top: 0px
        }

            
        .voltar{
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
            font-size: 20px;
        }

        
    </style>
</head>
<body>
    <div class="areaVoltarBtn">
        <a href="{{route('artigosSite')}}">
            <div class="voltar">
                Voltar
            </div>
        </a> 
    </div>   
    
    <h1>Obrigado pelo seu Registro!!!</h1><br>
    <h2>Abaixo está o link para o download!</h2><br>
    <a href="{{route('baixarArquivoArtigo',['nomeArquivo'=>$arquivo->nomeArquivo])}}">
        {{$arquivo->descricaoLink}}</a>
</body>
</html>