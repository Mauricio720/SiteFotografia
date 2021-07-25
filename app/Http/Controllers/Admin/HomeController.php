<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ConfigSite;
use Illuminate\Support\Facades\DB;
use App\Foto;
use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function verificarPermissoes($user){
        $permissoes=$user->permissoes;
        $permissoes=explode("/",$permissoes);
        
        $adm=in_array("ADM",$permissoes);
        $admSegundario=in_array("Adm Segundario",$permissoes);
        $configurações=in_array("Configurações",$permissoes);
     
        
        if($adm && $admSegundario && $configurações){
            return true;
        }else{
            return false;
        }
        
        
    }
    
     public function index()
    {
        $dadosView=[];
        $dadosConfig=ConfigSite::all();
        $dadosView['menus']=DB::select("SELECT * FROM tbmenus");
        $dadosView['fotos']=Foto::where('favorita',1)->get();
        if(count($dadosConfig) > 0){
            foreach($dadosConfig as $dado){
                $dadosView[$dado['titulo']]=$dado['valor'];
            }
        }
        $numWhatsApp=substr($dadosView['whatsApp'], 2);
        $dadosView['whatsApp']=$numWhatsApp;

        if(isset($dadosView['numContato']) && !empty($dadosView['numContato'])){
            $dadosView['numContatos']=explode(' ',$dadosView['numContato']);
        }

        return view('Admin.home',['configSite'=>$dadosView,'selectedMenu'=>'Home']);
    }

}

