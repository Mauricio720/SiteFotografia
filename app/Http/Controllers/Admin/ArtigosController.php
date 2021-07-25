<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Artigo;
use Illuminate\Http\Request;
use DOMDocument;


class ArtigosController extends Controller
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
        $artigos=in_array("Artigos",$permissoes);
         
        
        if($adm==false && $admSegundario==false && $artigos==false){
            return true;
        }else{
            return false;
        }        
    }

    public function __invoke(){
        $dadosArtigo=Artigo::orderBy('dataCriado','desc')
        ->orderBy('horaCriado','desc')
        ->join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->get();
        
        
        return view('Admin.artigos',['selectedMenu'=>'Artigos',
            'dadosArtigo'=>$dadosArtigo,'tituloDescricao'=>""]);
    }
    
    public function meusArtigos(){
        $dadosArtigo=Artigo::orderBy('dataCriado','desc')
        ->orderBy('horaCriado','desc')
        ->join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->where('tbartigos.idUsuario',Auth::user()->idUsuario)
        ->get();
        
        
        return view('Admin.meusArtigos',['selectedMenu'=>'Artigos',
            'dadosArtigo'=>$dadosArtigo,'tituloDescricao'=>""]);
    }

    public function pesquisarArtigo(Request $request){
        $dados=$request->only('tituloDescricao');
        
        if($request->has('tituloDescricao')){
            $tituloDescricao='%'.$dados['tituloDescricao'].'%';
            $dadosArtigo=Artigo::orderBy('dataCriado','desc')
                ->where('tituloArtigo','LIKE',$tituloDescricao)
                ->orWhere('descricaoArtigo','LIKE',$tituloDescricao)
                ->join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
                ->select('tbartigos.*','tbusuarios.nome')
                ->get();
            
            return view('Admin.artigos',['selectedMenu'=>'Artigos',
                'dadosArtigo'=>$dadosArtigo,'tituloDescricao'=>$dados['tituloDescricao']]);
        }
        
        $dadosArtigo=Artigo::orderBy('dataCriado','desc')
        ->join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->get();
        
        return view('Admin.meusArtigos',['selectedMenu'=>'Artigos',
                'dadosArtigo'=>$dadosArtigo,'tituloDescricao'=>""]);
        
    }

    public function pesquisarArtigoPorUsuario(Request $request){
        $dados=$request->only('tituloDescricao');
        
        if($request->has('tituloDescricao')){
            $tituloDescricao='%'.$dados['tituloDescricao'].'%';
            $dadosArtigo=Artigo::orderBy('dataCriado','desc')
                ->where('tbartigos.idUsuario',Auth::user()->idUsuario)
                ->where('tituloArtigo','LIKE',$tituloDescricao)
                ->orWhere('descricaoArtigo','LIKE',$tituloDescricao)
                ->where('tbartigos.idUsuario',Auth::user()->idUsuario)
                ->join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
                ->select('tbartigos.*','tbusuarios.nome')
                ->get();
            
            return view('Admin.meusArtigos',['selectedMenu'=>'Artigos',
                'dadosArtigo'=>$dadosArtigo,'tituloDescricao'=>$dados['tituloDescricao']]);
        }
        
        $dadosArtigo=Artigo::orderBy('dataCriado','desc')
        ->join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->where('tbartigos.idUsuario',Auth::user()->idUsuario)
        ->get();
        
        return view('Admin.meusArtigos',['selectedMenu'=>'Artigos',
                'dadosArtigo'=>$dadosArtigo,'tituloDescricao'=>""]);
    }

    public function cadastrarArtigo(Request $request){
        $dados=$request->only(['fotoArtigo','tituloArtigo','descricaoArtigo','autor','slug']);
        $this->validator($dados);
        
        
        if($request->has(['fotoArtigo','tituloArtigo','descricaoArtigo','autor'])){
            $tituloArtigo=$request->input('tituloArtigo');
            $tituloArtigo=trim(str_replace(" ","-",$dados['tituloArtigo']));
            $tituloArtigo=$this->tirarAcentos($tituloArtigo);
            $caminho="storage/imagens/artigos/".$this->limpar_caminho($tituloArtigo);
            $urlArtigo="imagens/artigos/".$this->limpar_caminho($tituloArtigo);
            $slug=$this->limpar_caminho($dados['slug']);
            if($slug=="_" || $slug==""){
                return redirect()->route('artigosPainel')->withErrors("Slug Artigo Invalido");
            }
            if(!file_exists($caminho)) {
                File::makeDirectory($caminho);
                $caminho=$caminho.'/fotoCapaArtigo/';
                File::makeDirectory($caminho);
            }

            if($request->file('fotoArtigo')->isValid()){
                $caminho="imagens/artigos/".$this->limpar_caminho($tituloArtigo)."/fotoCapaArtigo/";
                if($this->limpar_caminho($tituloArtigo)=="_" || $this->limpar_caminho($tituloArtigo)==""){
                    return redirect()->route('artigosPainel')
                    ->withErrors("Titulo Inválido");
                }
                $image=$request->file('fotoArtigo')->getClientOriginalName();
                if($this->verificarNomesIguaisFotoArtigo($image)){
                    return redirect()->route('artigosPainel')
                        ->withErrors("Titulo de foto ".$image." ja está sendo utilizado");
                }
                $image=trim(str_replace(" ","",$image));
                $request->file('fotoArtigo')->storeAs($caminho,$image);
                $caminho="imagens/artigos/".$this->limpar_caminho($tituloArtigo)."/fotoCapaArtigo/".$image;
            }
            
            $artigo=new Artigo();
            $artigo->tituloArtigo=$dados['tituloArtigo'];
            $artigo->descricaoArtigo=$dados['descricaoArtigo'];
            $artigo->autor=$dados['autor'];
            $artigo->fotoCapa=$caminho;
            $artigo->slug=$slug;
            $artigo->idUsuario=Auth::user()->idUsuario;
            $artigo->dataCriado=Carbon::now();
            $artigo->horaCriado=Carbon::now();
            $caminho=$caminho;
            $artigo->urlArtigo=$urlArtigo;
            $artigo->publicoCMS=1;
            $artigo->aprovado=0;
            $artigo->revisado=0;
            $artigo->notificacaoAprovado=0;
            $artigo->notificacaoRevisado=0;
            $artigo->notificacaoObservacao=0;
            $artigo->save();
        }

        return redirect()->route('artigosPainel');
    }
    
    private function verificarNomesIguaisFotoArtigo($nomeFotoArtigo){
        $artigos=DB::table('tbartigos')->get();
        $retorno=false;

        foreach ($artigos as $artigo) {
            $files=explode('/',$artigo->fotoCapa);
            $files=$files[4];
            if($files==$nomeFotoArtigo){
                $retorno=true;
            }
        }
        
        return $retorno;
    }

    public function atualizarArtigo(Request $request){
        $dados=$request->only(['fotoArtigo','tituloArtigo','descricaoArtigo'
            ,'autor','idArtigo','publico','html','slug']);
        
        $this->validatorEdit($dados);
        $artigo=DB::table('tbartigos')->where('idArtigo',$dados['idArtigo'])->first();
        $caminhoFoto=$artigo->fotoCapa;
        $caminho=$artigo->urlArtigo;
        $publico=0;
        $html=$artigo->html;
        $slug=$dados['slug'];

        if(!empty($dados['publico'])){
            $publico=1;
        }

        if($request->has(['tituloArtigo','descricaoArtigo','autor','slug'])){
            $tituloArtigo=$request->input('tituloArtigo');
            $tituloArtigo=trim(str_replace(" ","-",$dados['tituloArtigo']));
            
            if($slug != $artigo->slug){
                if($this->limpar_caminho($slug)=="_" || $this->limpar_caminho($slug)==""){
                    return redirect()->route('verArtigo',['idArtigo'=>$dados['idArtigo']])->withErrors("Slug ártigo invalido");
                }
                $slugVerificar=DB::table('tbartigos')->where('slug',$slug)->first();
                if($slugVerificar!=null){
                   
                    return redirect()->route('verArtigo',['idArtigo'=>$dados['idArtigo']])
                    ->withErrors("Esse Slug ja está sendo utilizado");
                }
            }
            if($artigo->tituloArtigo != $dados['tituloArtigo']){
                $tituloArtigo=$request->input('tituloArtigo');
                $tituloArtigo=trim(str_replace(" ","-",$dados['tituloArtigo']));
                $tituloArtigo=$this->tirarAcentos($tituloArtigo);

                $caminhoNovo="";
                
                $arquivo_antigo = 'storage/'.$artigo->urlArtigo;
                $caminhoNovo="storage/imagens/artigos/".$this->limpar_caminho($tituloArtigo);
                
                if($this->limpar_caminho($tituloArtigo)=="_" || $this->limpar_caminho($tituloArtigo)==""){
                    return redirect()->route('verArtigo',['idArtigo'=>$dados['idArtigo']])
                        ->withErrors("Titulo Inválido");
                }
                
                $caminho="imagens/artigos/".$this->limpar_caminho($tituloArtigo);
                $files=explode('/',$artigo->fotoCapa);
                $files=$files[4];
                $caminhoFoto="imagens/artigos/".$this->limpar_caminho($tituloArtigo)."/fotoCapaArtigo/".$files;
                $arquivo_novo = $caminhoNovo;
                rename($arquivo_antigo, $arquivo_novo); 
               
                $arquivoArtigos=DB::table('tbarquivosartigos')
                ->where('idArtigo',$dados['idArtigo'])
                ->get();

                foreach($arquivoArtigos as $arquivo){
                    $caminhoNovo="imagens/artigos/".$tituloArtigo
                    .'/arquivosArtigo/'.$arquivo->nomeArquivo;
                    DB::table('tbarquivosartigos')
                    ->where('idArtigo',$arquivo->idArtigo)
                    ->update(['urlArquivo'=>$caminhoNovo]);
                }
            }
            

            if(!empty($dados['fotoArtigo'])){
               
                if($request->file('fotoArtigo')->isValid()){
                    $image=$request->file('fotoArtigo')->getClientOriginalName();
                    if($this->verificarNomesIguaisFotoArtigo($image)){
                        return redirect()->route('verArtigo',['idArtigo'=>$dados['idArtigo']])
                            ->withErrors("Titulo de foto ".$image." ja está sendo utilizado");
                    }
                    
                    Storage::delete($artigo->fotoCapa);
                    $caminhoFoto="imagens/artigos/".$this->limpar_caminho($tituloArtigo)."/fotoCapaArtigo/";
                   
                    $image=trim(str_replace(" ","",$image));
                    $request->file('fotoArtigo')->storeAs($caminhoFoto,$image);
                    $caminhoFoto="imagens/artigos/".$this->limpar_caminho($tituloArtigo)."/fotoCapaArtigo/".$image;
                }
            }
        } 
        
        $artigo=Artigo::where('idArtigo',$dados['idArtigo'])->first();
        $artigo->tituloArtigo=$dados['tituloArtigo'];
        $artigo->slug=$slug;
        $artigo->descricaoArtigo=$dados['descricaoArtigo'];
        $artigo->autor=$dados['autor'];
        $artigo->fotoCapa=$caminhoFoto;
        $artigo->publicoCMS=$publico;
        $artigo->urlArtigo=$caminho;
        $artigo->html=$html;
        $artigo->save();

        return redirect()->route('verArtigo',['idArtigo'=>$dados['idArtigo']]);
    }

    
    private function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }

    private function limpar_caminho($string) {
        if($string !== mb_convert_encoding(mb_convert_encoding($string, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
            $string = mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string));
        $string = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $string);
        $string = html_entity_decode($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), ' ', $string);
        $string = preg_replace('/( ){2,}/', '$1', $string);
        $string = strtolower(trim($string));
        $string=str_replace(" ","-",$string);
        $string=str_replace("|","-",$string);
        return $string;
    }

    public function atualizarHtmlArtigo(Request $request){
        $dados=$request->only(['idArtigo','html','htmlEditor']);
        
        $artigo=Artigo::where('idArtigo',$dados['idArtigo'])->first();
        $artigo->html=$dados['html'];
        $artigo->htmlEdit=$dados['htmlEditor'];
        $artigo->save();

        $imagensRegistradasNoArtigo=DB::table('tbimagensartigo')->where('idArtigo',$dados['idArtigo'])->get();
        $imagensArtigo=$this->checarImagens($artigo->html);
        $this->excluirImagensNaoUsadas($imagensArtigo,$imagensRegistradasNoArtigo);

        return redirect()->route('artigosPainel');

    }

    private function excluirImagensNaoUsadas($imagensDoArtigo,$imagensRegistradasNoArtigo){
        $imagensDoArtigo = array_map('utf8_decode', $imagensDoArtigo);
        foreach ($imagensRegistradasNoArtigo as $imagensRegistradasArtigo) {
            if(!in_array($imagensRegistradasArtigo->nomeImagem,$imagensDoArtigo)){
                 Storage::delete($imagensRegistradasArtigo->urlImagem);
                 DB::table('tbimagensartigo')->where('urlImagem',$imagensRegistradasArtigo->urlImagem)->delete();
            }
        }
     }    
     
 
     private function checarImagens($html){
         $doc = new DOMDocument;
         $doc->loadHTML($html); //Faz o parse do HTML no php
         
         $imagens = array();
 
      foreach ($doc->getElementsByTagName('img') as $img)
      {
           $path = $img->getAttribute('src');
 
           if (!$path) continue;
 
           $imagens[] = basename($path);
      }
 
         return $imagens;
     }

    public function excluirArtigo($idArtigo){
        DB::table('tbimagensartigo')
        ->where('idArtigo',$idArtigo)
        ->delete();
        
        $artigo=Artigo::where('idArtigo',$idArtigo)->first();
        if($artigo !=null){
            Storage::deleteDirectory($artigo->urlArtigo);
            $arquivosArtigos=DB::table('tbarquivosartigos')
            ->where('idArtigo', $idArtigo)->first();
            if($arquivosArtigos!=null){
                $arquivosClientes=DB::table('tbarquivosclientes')
                    ->where('idArquivoArtigo',$arquivosArtigos->idArquivoArtigo)->get();
                if(count($arquivosClientes)==0){
                    DB::table('tbarquivosartigos')
                        ->where('idArtigo', $idArtigo)
                        ->delete();
                }
            }    
        }
        $artigo->delete();

        
        
        return redirect()->route('artigosPainel');
    }

    public function verArtigo($idArtigo){
        $artigo=DB::table('tbartigos')
               ->where('tbartigos.idArtigo',$idArtigo)
                ->first();
        
        $permissoes=explode("/",Auth::user()->permissoes);
        
        $arquivosArtigos=DB::table('tbarquivosartigos')
            ->join('tbartigos','tbarquivosartigos.idArtigo','=','tbartigos.idArtigo',)
            ->select('tbarquivosartigos.*','tbartigos.tituloArtigo')
            ->where('tbarquivosartigos.idArtigo',$idArtigo)
            ->get();
        
        if($artigo !=null){
            
            return view('Admin.verArtigo',['artigo'=>$artigo,
                'selectedMenu'=>'Artigos',
                'permissoes'=>$permissoes,
                'arquivosArtigos'=>$arquivosArtigos]);
            
            }

        return redirect()->route('artigosPainel');
    }

    public function verArtigoCriacao($idArtigo){
        $artigo=DB::table('tbartigos')
        ->where('tbartigos.idArtigo',$idArtigo)
         ->first();

         $arquivosArtigos=DB::table('tbarquivosartigos')
         ->join('tbartigos','tbarquivosartigos.idArtigo','=','tbartigos.idArtigo',)
         ->select('tbarquivosartigos.*','tbartigos.tituloArtigo')
         ->where('tbarquivosartigos.idArtigo',$idArtigo)
         ->get();

         $permissoes=explode("/",Auth::user()->permissoes);

         if($artigo !=null){
             return view('Admin.criacaoArtigo',['artigo'=>$artigo,
             'selectedMenu'=>'Artigos',
             'arquivosArtigos'=>$arquivosArtigos,
             'permissoes'=>$permissoes]);
         }

         return redirect()->route('artigosPainel');
    }

    public function verArtigoNotificacao($idArtigo){
        $artigo=DB::table('tbartigos')
               ->where('idArtigo',$idArtigo)
                ->first();
        
        
        if($artigo !=null){
            return redirect()->route('verArtigoCriacao',
                ['idArtigo'=>$artigo->idArtigo]);
        }

        return redirect()->route('artigosPainel');
    }

    public function verArtigoNotificacaoObservacao($idArtigo){
        $artigo=DB::table('tbartigos')
        ->where('idArtigo',$idArtigo)
         ->first();
 
        DB::table('tbartigos')->where('idArtigo',$idArtigo)
            ->update(['notificacaoObservacao'=>false]);
           
        
       if($artigo !=null){
            return redirect()->route('verArtigoCriacao',
                ['idArtigo'=>$artigo->idArtigo]);
        }
        return redirect()->route('artigosPainel');
            }

    public function addArquivoArtigo(Request $request){
        $dados=$request->only(['idArtigo','arquivoArtigo','descricaoLink']);
        $this->validatorArquivoArtigo($dados);

        if($request->has(['idArtigo','arquivoArtigo','descricaoLink'])){
            $artigo=Artigo::where('idArtigo',$dados['idArtigo'])->first();
            $caminho=$artigo->urlArtigo.'/arquivosArtigo/';
            
            if(!file_exists($caminho)) {
                Storage::makeDirectory($caminho);
            }

            if($request->file('arquivoArtigo')->isValid()){
                $nomeArquivo=$request->file('arquivoArtigo')->getClientOriginalName();
                if($this->verificarNomesIguaisArquivosArtigo($nomeArquivo,$dados['idArtigo'])){
                    return redirect()->route('verArtigoCriacao',['idArtigo'=>$dados['idArtigo']])
                    ->withErrors("Titulo do arquivo ".$nomeArquivo." 
                     está sendo utilizado em algum artigo ou foi baixado por algum cliente.
                     Troque o nome e tente novamente.");
                }
                $request->file('arquivoArtigo')->storeAs($caminho,$nomeArquivo);
                $caminho=$caminho.$nomeArquivo;
            }

            $arquivoArtigo=DB::table('tbarquivosartigos')
            ->insert(['descricaoLink'=>$dados['descricaoLink'],
                'urlArquivo'=>$caminho,'idArtigo'=>$dados['idArtigo'],
                'nomeArquivo'=>$nomeArquivo]);
        }
        
        return redirect()->route('verArtigoCriacao',['idArtigo'=>$dados['idArtigo']]);
    }

    public function editarArquivosArtigos(Request $request){
        $dados=$request->only(['idArtigo','idArquivoArtigo','arquivoArtigo','descricaoLink']);
        $this->validatorArquivoArtigoEdit($dados);

        if($request->has(['idArtigo','descricaoLink','idArquivoArtigo'])){
            $arquivoArtigo=DB::table('tbarquivosartigos')
            ->select('tbarquivosartigos.*')
            ->where('idArquivoArtigo',$dados['idArquivoArtigo'])
            ->first();
            
            $artigo=Artigo::where('idArtigo',$dados['idArtigo'])->first();

            $caminho=$artigo->urlArtigo.'/arquivosArtigo/';
            $nomeArquivo=$arquivoArtigo->nomeArquivo;

            if($request->only('arquivoArtigo')){
                Storage::delete($caminho.$nomeArquivo);

                if($request->file('arquivoArtigo')->isValid()){
                    $nomeArquivo=$request->file('arquivoArtigo')->getClientOriginalName();
                    if($this->verificarNomesIguaisArquivosArtigo($nomeArquivo)){
                        return redirect()->route('verArtigoCriacao',['idArtigo'=>$dados['idArtigo']])
                        ->withErrors("Titulo do arquivo ".$nomeArquivo." ja está sendo utilizado");
                    }
                    $request->file('arquivoArtigo')->storeAs($caminho,$nomeArquivo);
                    $caminho=$caminho.$nomeArquivo;
                }
            }
            
            $arquivoArtigo=DB::table('tbarquivosartigos')
            ->where('idArquivoArtigo',$dados['idArquivoArtigo'])
            ->update(['descricaoLink'=>$dados['descricaoLink'],
                'urlArquivo'=>$caminho,'idArtigo'=>$dados['idArtigo'],
                'nomeArquivo'=>$nomeArquivo]);
              
                
        }
        
        return redirect()->route('verArtigoCriacao',['idArtigo'=>$dados['idArtigo']]);
    }

    public function excluirArquivosArtigos($idArquivoArtigo){
        $arquivosArtigos=DB::table('tbarquivosartigos')->select('tbarquivosartigos.*')
            ->where('idArquivoArtigo',$idArquivoArtigo)->first();
        $idArtigo=$arquivosArtigos->idArtigo;
        
        if($arquivosArtigos!=null){
            Storage::delete($arquivosArtigos->urlArquivo);
            DB::table('tbarquivosartigos')->where('idArquivoArtigo', $idArquivoArtigo)->delete();
        }

        return redirect()->route('verArtigoCriacao',['idArtigo'=>$idArtigo]);

    }

    public function atualizarStatusArtigo(Request $request){
        $dados=$request->only(['aprovado','observacao','idArtigo']);
         $artigo=Artigo::where('idArtigo',$dados['idArtigo'])->first();
            
            $aprovado=null;
            
            if($request->only('aprovado')){
                $aprovado=$dados['aprovado'];
                $artigo->aprovado=$aprovado;
                $artigo->notificacaoAprovado=$aprovado;
                $artigo->save();
            }
            if($aprovado){
                
                $artigo->notificacaoRevisado=false;
                $artigo->notificacaoObservacao=false;
                $artigo->observacao="";
                $artigo->publicoCMS=true;
                $artigo->save();
            }
           
            if($request->has('observacao')){
                $artigo->observacao=$dados['observacao'];
                $artigo->notificacaoObservacao=1;
                $artigo->save();
                return redirect()->route('artigosPainel');

            }
        }

    private function verificarNomesIguaisArquivosArtigo($nomeArquivoArtigo){
        $artigosarquivos=DB::table('tbarquivosartigos')->get();
        $retorno=false;

        foreach ($artigosarquivos as $arquivo) {
            
            if($arquivo->nomeArquivo==$nomeArquivoArtigo){
                $retorno=true;
            }
        }
        
        return $retorno;
    }

    public function baixarArquivoArtigo($slugArtigo,$nomeArquivo){
        $idArtigo=Artigo::where('slug',$slugArtigo)->first();

        $arquivo=DB::table('tbarquivosartigos')
        ->where('nomeArquivo',$nomeArquivo)
        ->where('idArtigo',$idArtigo->idArtigo)
        ->first();
        
        return Storage::download($arquivo->urlArquivo);    

    }
    
    private function validator($dados){
        return Validator::make($dados,[
            'fotoArtigo'=>['required','image','mimes:jpeg,png,jpg,gif,svg','max:64240'],
            'tituloArtigo'=>['required','string','unique:tbartigos'],
            'autor'=>['required','string'],
            'slug'=>['required','string','unique:tbartigos']
        ])->validate();
    }

    private function validatorEdit($dados){
        return Validator::make($dados,[
            'fotoArtigo'=>['image','mimes:jpeg,png,jpg,gif,svg','max:64240'],
            'tituloArtigo'=>['required','string'],
            'slug'=>['required','string'],
            'autor'=>['required','string'],
        ])->validate();
    }

    private function validatorArquivoArtigo($dados){
        return Validator::make($dados,[
            'idArtigo'=>['required','int'],
            'arquivoArtigo'=>['required','file'],
            'descricaoLink'=>['required','string'],
        ])->validate();
    }

    private function validatorArquivoArtigoEdit($dados){
        return Validator::make($dados,[
            'idArtigo'=>['required','int'],
            'arquivoArtigo'=>['file'],
            'descricaoLink'=>['required','string'],
        ])->validate();
    }

}
