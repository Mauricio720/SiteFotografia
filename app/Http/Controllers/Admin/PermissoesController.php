<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;


class PermissoesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');

    }
    
    public function __invoke(){
        if(Auth::user()->ativo==false){
            Auth::logout();
            return redirect()->route('login')->withErrors("Usuario Inativo");;
            
        }
        
        return $this->verificarPermissoes();
    }

    private function verificarPermissoes(){
        $permissoes=Auth::user()->permissoes;
        $permissoes=explode("/",$permissoes);
        
        $adm=in_array("ADM",$permissoes);
        $admSegundario=in_array("Adm Segundario",$permissoes);
        $configurações=in_array("Configurações",$permissoes);
        $fotos=in_array("Fotos",$permissoes);
        $artigos=in_array("Artigos",$permissoes);
        $eventos=in_array("Eventos",$permissoes);
        $clientes=in_array("Clientes",$permissoes);   
        
        
        if($adm || $admSegundario || $configurações){
            return redirect()->route('admin');
        
        }else if($adm || $admSegundario || $fotos){
            return redirect()->route('portfolioPainel');
        
        }else if($adm || $admSegundario || $artigos){
            return redirect()->route('artigosPainel');
        
        }else if($adm || $admSegundario || $eventos){
            return redirect()->route('eventosPainel');
        
        }else if($adm || $admSegundario || $clientes){
            return redirect()->route('clientesPainel');
        }
        
        
    }

  
}
