<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ConfigSite;


class SeoController extends Controller
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
         
        if($adm==false && $admSegundario==false){
            return true;
        }else{
            return false;
        }        
    }

    
    
    public function __invoke(){
        $tituloSite= DB::table('tbconfigsite')->where('titulo','tituloSite')->first();
        $descricaoSite= DB::table('tbconfigsite')->where('titulo','descricaoSite')->first();
        $palavrasChave= DB::table('tbconfigsite')->where('titulo','palavrasChave')->first();
        $palavrasChaveArray=explode(',',$palavrasChave->valor);
        return view('Admin.seo',['selectedMenu'=>'SEO',
        'tituloSite'=>$tituloSite,'descricaoSite'=>$descricaoSite,
        'palavrasChave'=>$palavrasChave,'palavrasChaveArray'=>$palavrasChaveArray]);
    }

    public function atualizarSeo(Request $request){
        $dados=$request->only(['tituloSite','descricaoSite','palavrasChave','siteMap']);
        $request->validate([
            'tituloSite'=>['required','string'],
            'descricaoSite'=>['required','string'],
            'palavrasChave'=>['required','string']  
        ]);

        if($request->has('siteMap')){
            $request->validate([
                'siteMap'=>'mimes:txt,xml'
            ]);
            
            $caminho=public_path();;    
            
            $nomeArquivo='sitemap.'.$request->file('siteMap')->extension();
            $request->file('siteMap')->move($caminho,$nomeArquivo);
            
        }

        if($request->has(['tituloSite','descricaoSite','palavrasChave'])){
            $configSite=ConfigSite::where('titulo','tituloSite')->first();
            $configSite->valor=$dados['tituloSite'];
            $configSite->save();

            $configSite=ConfigSite::where('titulo','descricaoSite')->first();
            $configSite->valor=$dados['descricaoSite'];
            $configSite->save();
            
            $configSite=ConfigSite::where('titulo','palavrasChave')->first();
            $configSite->valor=$dados['palavrasChave'];
            $configSite->save();

            return redirect()->route('seoView');
        }

         return redirect()->route('seoView');
    }
}
