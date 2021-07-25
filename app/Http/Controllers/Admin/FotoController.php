<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Foto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class FotoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');
        $this->middleware(function ($request, $next) {  
            $this->user = auth()->user();
            if($this->verificarPermissoes($this->user)){
                return redirect()->route('permissoes');
            }
            return $next($request);
        });     
        
    }
    
    private function verificarPermissoes($user){
        $permissoes=$user->permissoes;

        $permissoes=explode("/",$permissoes);
        
        $adm=in_array("ADM",$permissoes);
        $admSegundario=in_array("Adm Segundario",$permissoes);
        $fotos=in_array("Fotos",$permissoes);
         
        if($adm==false  && $admSegundario==false && $fotos==false){
            return true; 
        }else{
            return false;
        }
    }


    public function __invoke(){
        
        $dadosArray=[];
        $dadosArray['albuns']=DB::table('tbalbumfoto')
            ->join('tbcategoriaalbum','tbalbumfoto.idcategoria','=','tbcategoriaalbum.idcategoria')
            ->join('tbusuarios','tbalbumfoto.idUsuario','=','tbusuarios.idUsuario')
            ->select('tbalbumfoto.*','tbcategoriaalbum.*','tbusuarios.*')
            ->orderBy('dataCriacao','desc')
            ->orderBy('horaCriacao','desc')
            ->get(); 
        
        $dadosArray['category']=DB::table('tbcategoriaalbum')->get();
        $dadosArray['selectedMenu']='Fotos';
        return view('Admin.portfolio',$dadosArray);
    }

  

    public function marcarDesmarcarComoFavorita($idFoto,$idTela){
        $foto=Foto::where('idFoto',$idFoto)->first();
        $foto->favorita=1-$foto->favorita;
        if($foto->favorita==1){
            $foto->dataFavoritada=Carbon::now();
            $foto->horaFavoritada=Carbon::now();
        }
        $foto->save();
        
        if($idTela==1){
            return redirect()->route('admin');
        }else{
            $idAlbum=Foto::where('idFoto',$idFoto)->first('idAlbum');
            $idAlbum=$idAlbum->idAlbum;
            return redirect()->route('fotosAlbum',['idAlbum'=>$idAlbum]);
        }
    }

    public function adicionarCategoria(Request $request){
        if($request->has('nomeCategoria')){
            $request->validate([
                'nomeCategoria'=>['required','string','unique:tbcategoriaalbum']
            ]);

            $nomeCategoria=$request->input('nomeCategoria');
            $slugCategoria=$this->geradorDeSlugCategoria($nomeCategoria);
            $caminho="storage/imagens/albuns/".$this->limpar_caminho($nomeCategoria);
            
            if($this->limpar_caminho($nomeCategoria)=="_"){
                return redirect()->route('portfolioPainel')->withErrors("O nome digitado pra categoria é inválido!");
            }

            if(!file_exists($caminho)) {
                File::makeDirectory($caminho);
            }
            
        }
        DB::insert('INSERT INTO tbcategoriaalbum(nomeCategoria,slugCategoria) 
            VALUES(:categoria,:slugCategoria)',[':categoria'=>$nomeCategoria,':slugCategoria'=>$slugCategoria]);
        
        return redirect()->route('portfolioPainel');
    }

    public function excluirCategoria(int $idCategoria){
        if(isset($idCategoria) && !empty($idCategoria)){
            $nomeCategoria=$this->pegarNomeCategoria($idCategoria);
           
            Storage::deleteDirectory("imagens/albuns/".trim($nomeCategoria));
            

            $albuns=DB::table('tbalbumfoto')->select('idAlbum')
                ->where('idCategoria',$idCategoria)->get();
            
            if($albuns!=null){
                
                foreach ($albuns as $album) {
                    $fotos=Foto::where('idAlbum',$album->idAlbum)->get();
                    if($fotos!=null){
                        foreach($fotos as $foto){
                            $foto->delete();
                        }
                    }
                    DB::delete('DELETE FROM tbfichatecnica WHERE idAlbum=:idAlbum'
                        ,[':idAlbum'=>$album->idAlbum]);
                    
                    DB::delete('DELETE FROM tbalbumfoto WHERE idAlbum=:idAlbum'
                        ,[':idAlbum'=>$album->idAlbum]);
                }
            }
            
            DB::delete('DELETE FROM tbcategoriaalbum WHERE idCategoria=:idCategoria'
            ,[':idCategoria'=>$idCategoria]);
            
            
            return redirect()->route('portfolioPainel');
        }
    }

    public function addAlbumView($idCategoria){
        $dados=DB::table('tbalbumfoto')->where('idAlbum','=',$idCategoria)->first();
        return view('Admin.album',['idCategoria'=>$idCategoria,'selectedMenu'=>'Fotos']);
        
    }

    public function editAlbumView($idAlbum){
        $dados['dadosAlbum']=DB::table('tbalbumfoto')
                                ->join('tbfichatecnica', 'tbalbumfoto.idAlbum', '=','tbfichatecnica.idAlbum')
                                ->where('tbalbumfoto.idAlbum','=',$idAlbum)
                                ->select('tbalbumfoto.*', 'tbfichatecnica.html')
                                ->first();
        $dados['selectedMenu']='Fotos';

        if($dados['dadosAlbum'] != null){
            return view('Admin.editAlbum',$dados);
        }else{
            redirect()->route('portfolioPainel');
        }
    }

    public function addAlbum(Request $request){
        $dados=$request->only(['fotoAlbum','tituloAlbum','dataEvento','idCategoria',
        'descricaoAlbum','fichaTecnica','slug']);
        
        if($request->has(['fotoAlbum','tituloAlbum','dataEvento','idCategoria',
                'fichaTecnica','descricaoAlbum','slug'])){
            
            $validatorAlbum=$this->validatorAlbum($dados);
            if($validatorAlbum->fails()){
                return redirect()->route('addAlbumView',['idCategoria'=>$dados['idCategoria']])
                ->withErrors($validatorAlbum)
                ->with('idCategoria', $dados['idCategoria']);
            }            
            
            $tituloAlbum=$dados['tituloAlbum'];
            $tituloAlbum=$this->tirarAcentos($tituloAlbum);
            $slug=$this->geradorDeSlug($dados['slug']);
            $slug=$this->tirarAcentos($slug);
            
            if($slug=="_" || $slug==""){
                return redirect()->route('addAlbumView',['idCategoria'=>$dados['idCategoria']])
                ->withErrors("Slug do album inválido");
            }
            $nomeCategoria=$this->pegarNomeCategoria($dados['idCategoria']);
            $fotoCapa="imagens/albuns/".$this->limpar_caminho($nomeCategoria)."/".$this->limpar_caminho($tituloAlbum)."/fotoCapa/";
            $url="imagens/albuns/".$nomeCategoria."/".$tituloAlbum;
            $idCategoria=$dados['idCategoria'];
            $image="";
            
            if($this->limpar_caminho($tituloAlbum)=="_"){
                return redirect()->route('addAlbumView',['idCategoria'=>$dados['idCategoria']])
                ->withErrors("Titulo do album inválido");
            }
            
            if($request->file('fotoAlbum')->isValid()){
                $image=$request->file('fotoAlbum')->getClientOriginalName();
                $image=trim(str_replace(" ","",$image));
                if($this->verificarNomesIguaisAlbum($image,$idCategoria)){
                    return redirect()->route('addAlbumView',['idCategoria'=>$dados['idCategoria']])
                        ->withErrors("Titulo da imagem da foto de capa ".$image.
                        " ja está sendo utilizado nessa categoria!");
                }
                $request->file('fotoAlbum')->storeAs($fotoCapa,$image);
            }
            
            
            DB::table('tbalbumfoto')->insert(['tituloAlbum'=>$dados['tituloAlbum'],'urlAlbum'=>$url,
                'fotoCapa'=>$fotoCapa.$image,'dataEvento'=>$dados['dataEvento'],'idCategoria'=>$dados['idCategoria'],
                    'dataCriacao'=>Carbon::now(),'horaCriacao'=>Carbon::now(),'idUsuario'=>Auth::user()->idUsuario,
                        'slug'=>$slug,'descricaoAlbum'=>$dados['descricaoAlbum'],
                        'view'=>0,'curtida'=>0,'tituloFoto'=>$image]);                                                    
                                                                
            $lastInsertedID = DB::table('tbalbumfoto')->max('idAlbum');
            $fichaTecnica=$dados['fichaTecnica'];
            
            DB::insert('INSERT INTO tbfichatecnica(idAlbum,html) VALUES(:idAlbum,:html)
                ',[':idAlbum'=>$lastInsertedID,':html'=>$fichaTecnica]);
            
            
            }else{
                $validatorAlbum=$this->validatorAlbum($dados);
                if($validatorAlbum->fails()){
                    return redirect()->route('addAlbumView',['idCategoria'=>$dados['idCategoria']])
                           ->withErrors($validatorAlbum);
                           
                }
            }
            
           return redirect()->route('portfolioPainel');
    }

    private function limpar_caminho($string) {
        if($string !== mb_convert_encoding(mb_convert_encoding($string, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
            $string = mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string));
        $string = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $string);
        $string = html_entity_decode($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), ' ', $string);
        $string = preg_replace('/( ){2,}/', '$1', $string);
        $string=str_replace(" ","-",$string);
        $string=str_replace("|","-",$string);
        return $string;
    }


    private function verificarNomesIguaisAlbum($nomeAlbum,$idCategoria){
        $albuns=DB::table('tbalbumfoto')->where('idCategoria',$idCategoria)->get();
        $retorno=false;

        foreach ($albuns as $album) {
            $files=explode('/',$album->fotoCapa);
            $files=$files[5];
            if($files==$nomeAlbum){
                $retorno=true;
            }
        }
        
        return $retorno;
    }

    public function editarAlbum(Request $request){
        $dados=$request->only(['slug','idAlbum','fotoAlbum','tituloAlbum','dataEvento',
            'idCategoria','fichaTecnica','descricaoAlbum']);
        if($request->has(['idAlbum','tituloAlbum','dataEvento','idCategoria','fichaTecnica','descricaoAlbum'])){
            
            $tituloAlbum=trim(str_replace(" ","-",$dados['tituloAlbum']));;
            $album=DB::table('tbalbumfoto')->where('idAlbum','=',$dados['idAlbum'])
            ->first();
             $tituloAlbumCadastrado=trim(str_replace(" ","-",$album->tituloAlbum));   
            $idCategoria=$dados['idCategoria'];
            $image=$album->tituloFoto;

            if($tituloAlbum==$tituloAlbumCadastrado){
                $validatorAlbumEdit=$this->validatorAlbumEditComTituloAlbumIgual($dados);
            }else{
                $validatorAlbumEdit=$this->validatorAlbumEdit($dados);
            }
            
            if($validatorAlbumEdit->fails()){
                return redirect()->route('editarAlbumView',['idAlbum'=>$dados['idAlbum']])
                ->withErrors($validatorAlbumEdit)
                ->with('idCategoria', $dados['idAlbum']);
            }            
            
            if($album->slug==$dados['slug']){
                $slugAlbum=$album->slug;
            }else{
                $slugAlbum=$this->geradorDeSlug($dados['slug']);
                if($slugAlbum=="_" || $slugAlbum==""){
                    return redirect()->route('editarAlbumView',['idAlbum'=>$dados['idAlbum']])
                    ->withErrors("Slug inválido");;
                }
            }
            
            $nomeCategoria=$this->pegarNomeCategoria($dados['idCategoria']);
            $url="imagens/albuns/".$nomeCategoria."/".$tituloAlbum;
         
            $fotoCapa=$album->fotoCapa;    

            if($tituloAlbumCadastrado!=$tituloAlbum){
                $slugAlbum=$this->geradorDeSlug($tituloAlbum);
                $slugAlbum=$this->tirarAcentos($this->limpar_caminho($slugAlbum));
                $url="imagens/albuns/".$this->limpar_caminho($nomeCategoria)."/".$this->limpar_caminho($tituloAlbum);
                if($this->limpar_caminho($tituloAlbum)=="_" || $slugAlbum==""){
                    return redirect()->route('editarAlbumView',['idAlbum'=>$dados['idAlbum']])
                    ->withErrors("Titulo do album inválido");
                }
                if(!file_exists($url)) {
                    $files=explode('/',$album->fotoCapa);
                    $files=$files[5];
                    $novoCaminho= $url."/fotoCapa/".$files;
                    $velhoCaminho=$album->fotoCapa;
                    
                    if($novoCaminho!=$velhoCaminho){
                        Storage::makeDirectory($url."/fotoCapa/");
                        Storage::move($album->fotoCapa, $novoCaminho);
                        Storage::deleteDirectory($album->urlAlbum);
                    }

                   
                    if(!file_exists($album->urlAlbum.'/fotosAlbum')){
                        Storage::makeDirectory($url."/fotosAlbum/");
                        $filesPicture=Storage::allFiles($album->urlAlbum.'/fotosAlbum/');
                        $allFiles=[];
                        foreach($filesPicture as $file){
                            $file=explode('/',$file);
                            $allFiles[]=$file[5];
                        }
                        
                        foreach($allFiles as $file){
                            Storage::move($album->urlAlbum.'/fotosAlbum/'.$file
                            ,$url."/fotosAlbum/".$file);
                            
                            $fotos=Foto::where('caminhoFoto',
                                    '=',$album->urlAlbum.'/fotosAlbum/'.$file)->first();
                            $fotos->caminhoFoto=$url."/fotosAlbum/".$file;
                            $fotos->save();
                        }
                    }
                        $fotoCapa=$url."/fotoCapa/".$files;
                }
            }
            
            if($request->has('fotoAlbum')){
                if($request->file('fotoAlbum')->isValid()){
                    
                    $image=$request->file('fotoAlbum')->getClientOriginalName();
                    $image=trim(str_replace(" ","",$image));
                    if($this->verificarNomesIguaisAlbum($image,$idCategoria)){
                        return redirect()->route('editarAlbumView',['idAlbum'=>$dados['idAlbum']])
                            ->withErrors("Titulo da imagem da foto de capa ".$image."
                             ja está sendo utilizado nessa categoria!");
                    }
                    Storage::delete($fotoCapa);
                    $request->file('fotoAlbum')->storeAs($url.'/fotoCapa/',$image);
                    $fotoCapa=$url."/fotoCapa/".$image;
                }
            }

            DB::table('tbalbumfoto')
              ->where('idAlbum', $dados['idAlbum'])
              ->update(['tituloAlbum' => $dados['tituloAlbum'],'urlAlbum'=>$url,
                    'dataEvento'=>$dados['dataEvento'],'idCategoria'=>$dados['idCategoria'],
                        'fotoCapa'=>$fotoCapa,'idAlbum'=>$dados['idAlbum'],
                            'slug'=>$slugAlbum,'descricaoAlbum'=>$dados['descricaoAlbum'],
                            'tituloFoto'=>$image]);
            
            $fichaTecnica=$dados['fichaTecnica'];
            
            DB::update('UPDATE tbfichatecnica SET html=:html WHERE idAlbum=:idAlbum
                ',[':idAlbum'=>$dados['idAlbum'],':html'=>$fichaTecnica]);
            
            
            }else{
                $validatorAlbumEdit=$this->validatorAlbumEdit($dados);
                if($validatorAlbumEdit->fails()){
                    return redirect()->route('editarAlbumView',['idAlbum'=>$dados['idAlbum']])
                    ->withErrors($validatorAlbumEdit)
                    ->with('idCategoria', $dados['idAlbum']);
                           
                }
            }
            
           return redirect()->route('portfolioPainel');
    }

    public function excluirAlbum($idAlbum){
        $album=DB::table('tbalbumfoto')->where('idAlbum','=',$idAlbum)->first();
        if($album!=null){
            $urlAlbum=$album->urlAlbum;
            Storage::deleteDirectory($urlAlbum);
            $fotos=Foto::where('idAlbum',$idAlbum)->get();
            if($fotos!=null){
                foreach($fotos as $foto){
                    $foto->delete();
                }
            }
            
            DB::delete('DELETE FROM tbfichatecnica WHERE idAlbum=:idAlbum'
            ,[':idAlbum'=>$idAlbum]);

            DB::delete('DELETE FROM tbalbumfoto WHERE idAlbum=:idAlbum'
            ,[':idAlbum'=>$idAlbum]);
        }

        return redirect()->route('portfolioPainel');
    }

    private function geradorDeSlug($tituloAlbum){
        $slug=$this->limpar_caminho($tituloAlbum);
        $slugCadastrado=DB::table('tbalbumfoto')->where('slug',$slug)->get();
        $slugFinal="";
        if(count($slugCadastrado)>0){
            $quantidadeSlug=count($slugCadastrado);
            for ($i=0; $i < $quantidadeSlug ; $i++) { 
                $slugFinal=$this->generateRandomString($quantidadeSlug);
            }
            $slug=$slug.'-'.$slugFinal;
            $slogNovo=DB::table('tbalbumfoto')->where('slug',$slug)->first();
            if($slogNovo!=null){
                $this->geradorDeSlug($tituloAlbum);
            }
        }

        return $slug;
    }

    private function geradorDeSlugCategoria($tituloCategoria){
        $slug=$this->limpar_caminho($tituloCategoria);
        $slugCadastrado=DB::table('tbcategoriaalbum')->where('slugCategoria',$slug)->get();
        $slugFinal="";
        if(count($slugCadastrado)>0){
            $quantidadeSlug=count($slugCadastrado);
            for ($i=0; $i < $quantidadeSlug ; $i++) { 
                $slugFinal=$this->generateRandomString($quantidadeSlug);
            }
            $slug=$slug.'-'.$slugFinal;
            $slogNovo=DB::table('tbalbumfoto')->where('slug',$slug)->first();
            if($slogNovo!=null){
                $this->geradorDeSlugCategoria($tituloCategoria);
            }
        }

        return $slug;
    }

    private function generateRandomString($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[Rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function fotosAlbumView($idAlbum){
        $fotos=DB::table('tbfotos')
        ->join('tbusuarios','tbfotos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbfotos.*','tbusuarios.*')
        ->where('idAlbum',$idAlbum)
        ->get(); 
        $nomeAlbum=DB::table('tbalbumfoto')->where('idAlbum','=',$idAlbum)->first('tituloAlbum');
        $nomeAlbum=$nomeAlbum->tituloAlbum;
        
        return view('Admin.fotos',['fotos'=>$fotos,'tituloAlbum'=>$nomeAlbum,
            'idAlbum'=>$idAlbum,'selectedMenu'=>'Fotos']);
    }

    public function excluirFoto($idFoto){
        $foto=Foto::where('idFoto',$idFoto)->first();
        if($foto!=null){
         $foto->delete();
            Storage::delete('storage/'.$foto->caminhoFoto);
        }
        return redirect()->route('fotosAlbum',
            ['idAlbum'=>$foto->idAlbum,'selectedMenu'=>'Fotos']);
    }

    public function addFoto(Request $request){
        $dados=$request->only(['fotos','idAlbum']);
        $validatorFoto=$this->validatorFotos($dados);
        
        if($request->has('fotos','idAlbum')){
            if($validatorFoto->fails()){
                return redirect()->route('fotosAlbum',['idAlbum'=>$dados['idAlbum']])
                    ->withErrors($validatorFoto);
                
            }
            $fotos=$dados['fotos'];
            $caminho=DB::table('tbalbumfoto')->where('idAlbum','=',$dados['idAlbum'])
                        ->first('urlAlbum');

            foreach($fotos as $foto){
                if($foto->isValid()){
                    $image=$foto->getClientOriginalName();
                    if($this->verificarNomesIguaisFotos($image)){
                        return redirect()->route('fotosAlbum',
                            ['idAlbum'=>$dados['idAlbum'],'selectedMenu'=>'Fotos'])
                                ->withErrors("Titulo ".$image." ja está sendo utilizado!");;
                    }
                    $foto->storeAs($caminho->urlAlbum.'/fotosAlbum/',$image);
                    $fotosAlbum=new Foto();
                    $fotosAlbum->tituloFoto=$foto->getClientOriginalName();
                    $fotosAlbum->caminhoFoto=$caminho->urlAlbum.'/fotosAlbum/'.$image;
                    $fotosAlbum->idAlbum=$dados['idAlbum'];
                    $fotosAlbum->dataAdicao=Carbon::now();
                    $fotosAlbum->horaAdicao=Carbon::now();
                    $fotosAlbum->idUsuario=Auth::user()->idUsuario;
                    $fotosAlbum->favorita=0;
                    $fotosAlbum->save();
                }
            }
            
        }else{
            return redirect()->route('fotosAlbum',
                ['idAlbum'=>$dados['idAlbum'],'selectedMenu'=>'Fotos'])
                ->withErrors($validatorFoto);;
            
        }

        return redirect()->route('fotosAlbum',
            ['idAlbum'=>$dados['idAlbum'],'selectedMenu'=>'Fotos']);
        
    }

    private function verificarNomesIguaisFotos($nomeImagem){
        $fotos=Foto::all();
        $retorno=false;

        foreach ($fotos as $foto) {
            if($foto->tituloFoto==$nomeImagem){
                $retorno=true;
            }
        }
        
        return $retorno;
    }

    private function pegarNomeCategoria($idCategoria){
        $nomeCategoria=DB::table('tbcategoriaalbum')->select('nomeCategoria')
            ->where('idCategoria',$idCategoria)->first();
       
        return $nomeCategoria->nomeCategoria;
    }

    private function validatorAlbum($dados){
        return Validator::make($dados,[
            'fotoAlbum'=>['required','image','mimes:jpeg,png,jpg,gif,svg'],
            'tituloAlbum'=>['required','string','max:1000'],
            'dataEvento'=>['required','date','string'],
            'idCategoria'=>['required','int'],
            'fichaTecnica'=>['required','string','max:4294967295'],
            'descricaoAlbum'=>['required','string','max:4294967295'],
        ]);
    }

    private function validatorAlbumEdit($dados){
        return Validator::make($dados,[
            'fotoAlbum'=>['image','mimes:jpeg,png,jpg,gif,svg'],
            'tituloAlbum'=>['required','string','max:1000'],
            'dataEvento'=>['required','date','string'],
            'idCategoria'=>['required','int'],
            'fichaTecnica'=>['required','string','max:4294967295'],
            'idAlbum'=>['required','int'],
            'descricaoAlbum'=>['required','string','max:4294967295'],
        ]);
    }

    private function validatorFotos($dados){
        return Validator::make($dados,[
            'fotos.*'=>['required','image','mimes:jpeg,png,jpg,gif,svg','max:67108864'],
            'idAlbum'=>['required','int'],
        ]);
    }

    private function validatorAlbumEditComTituloAlbumIgual($dados){
        return Validator::make($dados,[
            'fotoAlbum'=>['image','mimes:jpeg,png,jpg,gif,svg'],
            'tituloAlbum'=>['required','string','max:1000'],
            'dataEvento'=>['required','date','string'],
            'idCategoria'=>['required','int'],
            'fichaTecnica'=>['required','string'],
            'idAlbum'=>['required','int'],
            'descricaoAlbum'=>['required','string','max:4294967295'],

        ]);
    }

    private function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }
    
}
