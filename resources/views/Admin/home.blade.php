@extends('layouts.templateCMS')

@section('content')
    <section class="configPage">
        
        <div class="containerConfig">
            <div class="miniSite">
                <div class="miniMenu" style="background-color: {{$configSite['corMenu']}}">
                    <form method="POST" action="{{route('salvarConfig')}}"
                        id="formMenu" enctype="multipart/form-data">

                        @csrf   

                        <ul>
                            <div class="logoEdit">
                                <img src="{{asset("storage/imagens/configImagens/logo/"
                                    .$configSite["logo"])}}"
                                    width="100%" height="100%">
                            </div>
                            <input type="file" name="logoFoto" id="logoFoto">

                            @foreach ($configSite["menus"] as $key=>$menu)
                                <li>
                                    <input type="text" value="{{$menu->titulo}}" 
                                        key="{{$menu->numMenu}}" 
                                        name="menu-{{$menu->numMenu}}" 
                                        required 
                                        style="color:{{$configSite['corFonteMenu']}}"
                                        autocomplete="off">
                                </li>
                            @endforeach

                        <div class="opcaoCores">
                            <input type="color" name="corMenu" value="{{$configSite['corMenu']}}"/>
                            <label>Cor Menu</label> 
                        </div> 

                        <div class="opcaoCores">
                            <input type="color" name="corFonte"
                                value="{{$configSite['corFonteMenu']}}"/>
                            <label style="margin-left: 5px">Cor Fonte</label>                            
                        </div>
                    </form>
                </div> 

            <div class="conteudoMiniSite">
                <div class="containerConteudoMiniSite"
                    style="background-color: {{$configSite['corPagina']}}">

                    <div class="corPagina">
                        <div class="opcaoCores">
                            <input type="color" value="{{$configSite['corPagina']}}" id="corPagina">
                            <label>Cor Pagina</label>
                        </div>
                    </div>    

                    <div class='paginaHome paginaConteudo' active="active">
                        <h4><center>Fotos Favoritas</center></h4>
                        
                        <div class="containerFotosFavoritas">
                            @forelse ($configSite['fotos'] as $foto)
                                <div class="fotoFavorita">
                                    <a href="{{route('marcarDesmarcarFoto',
                                        ['idFoto'=>$foto->idFoto,'idTela'=>1])}}">

                                        <div class="estrelaFotoFavorita">

                                        <img src="{{asset('storage/imagens/iconsSite/star.png')}}"
                                                width="100%" height="100%">
                                        </div>
                                    </a>

                                    <img src="{{asset('storage/'.$foto->caminhoFoto)}}" 
                                        width="100%"> 
                                </div>

                            @empty

                            @endforelse
                        </div>
                    </div>

                    <div class="paginaSobre paginaConteudo" active="">
                        <form method="POST" action="{{route('salvarConfig')}}"
                            id="formSobre" enctype="multipart/form-data">
                            @csrf

                            <label><center>Titulo Pagina Sobre</center></label>
                            <input type="text" name="tituloSobre" 
                                id="tituloSobre" value="{{$configSite['tituloSobre']}}" required>
                            
                            <div class="bannerAbout" 
                                style="background-image: 
                                    url({{asset('storage/imagens/configImagens/bannerAbout/'
                                    .$configSite['bannerAbout'])}})">
                            </div><br>
                            <input type="file" name="bannerAbout" id="bannerAbout"><br>
                            
                            <textarea name="sobre" id="sobre" cols="30" 
                                rows="10"autocomplete="off" required>
                                {{$configSite['sobre']}};
                            </textarea>
                        </form>
                    </div>

                    <div class="paginaContato paginaConteudo" active="">
                        <h4>Informações de contato</h4>

                        <form method="POST" action="{{route('salvarConfig')}}" 
                            id="formContato" enctype="multipart/form-data">
                            @csrf

                            <div class=form-group>
                                <label>Banner de Contato*</label>
                                <div class="bannerContact" 
                                    style="background-image: 
                                    url({{asset('storage/imagens/configImagens/bannerContact/'
                                    .$configSite['bannerContact'])}})">
                                </div><br>
                                <input type="file" name="bannerContact" id="bannerContact">
                                
                                <label>Email de Contato*</label>
                                <input class="form-control" type="email"
                                    name="emailContato" id="emailContato"
                                    value="{{$configSite['emailContato']}}"
                                    required
                                />
                            </div>

                            <div class=form-group>
                                <label>Num WhatsApp*</label>
                                <input class="form-control" type="tel"
                                    name="numWhatsApp" id="numWhatsApp"
                                    value="{{$configSite['whatsApp']}}"
                                />
                            </div>

                            <div class=form-group>
                                <label>Num Contato</label>
                                <input class="form-control" type="tel"
                                    name="numContato" id="numContato"
                                    value="{{$configSite['numContato']}}"
                                />
                            </div>
                            
                            
                            <div class=form-group>
                                <label>Link Instagram*</label>
                                <input class="form-control" type="url"
                                    name="instagramLink" id="instagramLink"
                                    value="{{$configSite['instagramLink']}}"
                                />
                            </div>

                            <div class=form-group>
                                <label>Link Email*</label>
                                <input class="form-control" type="text"
                                    name="emailLink" id="emailLink"
                                    value="{{$configSite['emailLink']}}"
                                />
                            </div>

                            <div class=form-group>
                                <label>Link Pinterest*</label>
                                <input class="form-control" type="url"
                                    name="pinterestLink" id="pinterestLink"
                                    value="{{$configSite['pinterestLink']}}"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
        
        
    <div class="areaBtn">
        <button class="btn btn-primary" id="salvarConfig">Salvar</button>
            <div class="alert alert-danger" id="Alert" style="display: none;">
                <ul>

                </ul>
            </div>
        </div>
    </div>
</section>
                            




<script src="{{asset('js/scriptConfigCms.js')}}"></script>



@endsection

