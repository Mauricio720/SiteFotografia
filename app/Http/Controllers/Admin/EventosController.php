<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EventosController extends Controller
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
        $eventos=in_array("Eventos",$permissoes);
     
        if($adm==false && $admSegundario==false && $eventos==false){
            return true;
        }else{
            return false;
        }
        
        
    }

    public function __invoke(){
        $dadosEventos=$this->retornarDadosEvento();
        return view('Admin.eventos',['dadosEventos'=>$dadosEventos,'nomeCliente'=>"",
            'dataRegistroEvento'=>"",'selectedMenu'=>'Eventos']);
    }

    public function mostrarTelaPorNotificacao($idEvento){
        $dadosEventos=$this->retornarDadosEvento();
        
        $dadosEventoNotificacao=DB::table('tbeventos')
        ->join('tbclientes', 'tbeventos.idCliente', '=', 'tbclientes.idCliente')
        ->select('tbeventos.*', 'tbclientes.nome','tbclientes.idCliente',
                    'tbclientes.email','tbclientes.telefone')
        ->where('idEvento',$idEvento)
        ->orderBy('dataRegistroEvento','desc')
        ->get();

        DB::table('tbeventos')->where('idEvento',$idEvento)->update(['notificacao'=>0]);

        return view('Admin.eventos',['dadosEventos'=>$dadosEventos,'nomeCliente'=>"",
            'dataRegistroEvento'=>"",'dadosEventoNotificacao'=>$dadosEventoNotificacao,
                'selectedMenu'=>'Eventos']);
        
    }

    
    public function marcarDesmarcarEvento($idEvento){
        $confirmarValor=DB::table('tbeventos')->select('confirmar')->where('idEvento',$idEvento)->first();
        $confirmarValor=$confirmarValor->confirmar;
        
        $evento=DB::table('tbeventos')->where('idEvento',$idEvento)
            ->update(['confirmar' => 1-$confirmarValor]);;
        
        return redirect()->route('eventosPainel');
    }

    public function pesquisarPorClienteOuData(Request $request){
        $dados=$request->only(['nomeCliente','dataEvento']);
        $this->validator($dados);
        
        if($request->has('nomeCliente') && empty('dataEvento')){
            $dadosEventos=$this->retornarDadosEvento($dados['nomeCliente']);
            return view('Admin.eventos',['dadosEventos'=>$dadosEventos,
                'nomeCliente'=>$dados['nomeCliente'],
                    'dataRegistroEvento'=>$dados['dataRegistroEvento'],
                        'selectedMenu'=>'Eventos']);
            
        }else if($request->has('dataEvento') && empty('nomeCliente')){
          
            $dadosEventos=$this->retornarDadosEvento($dados['dataRegistroEvento']);
            return view('Admin.eventos',['dadosEventos'=>$dadosEventos,
                'nomeCliente'=>$dados['nomeCliente'],
                    'dataRegistroEvento'=>$dados['dataRegistroEvento'],'selectedMenu'=>'Eventos']);
        
        }else if($request->has(['nomeCliente','dataEvento'])){
            $dadosEventos=$this->retornarDadosEvento($dados['nomeCliente'],$dados['dataEvento']);
            return view('Admin.eventos',['dadosEventos'=>$dadosEventos,
                'nomeCliente'=>$dados['nomeCliente'],
                    'dataRegistroEvento'=>$dados['dataRegistroEvento'],'selectedMenu'=>'Eventos']);
            
        }else if(empty($dados['nomeCliente']) && empty($dados['dataEvento'])){
            $dadosEventos['dadosEventos']=$this->retornarDadosEvento();
            return view('Admin.eventos',$dadosEventos);
        }
    }

    public function retornarDadosEvento($nomeCliente="",$dataRegistroEvento=""){
        $dadosEvento=[];
        if(!empty($nomeCliente) && empty($dataRegistroEvento)){
            $nomeCliente='%'.$nomeCliente.'%';

            $dadosEvento= DB::table('tbeventos')
                ->join('tbclientes', 'tbeventos.idCliente', '=', 'tbclientes.idCliente')
                ->select('tbeventos.*', 'tbclientes.nome','tbclientes.idCliente','tbclientes.email','tbclientes.telefone')
                ->where('tbclientes.nome','LIKE',$nomeCliente)->orderBy('dataRegistroEvento','desc')->get();

        
        }else if(!empty($dataRegistroEvento) && empty($nomeCliente) ){
            $dadosEvento= DB::table('tbeventos')
                ->join('tbclientes', 'tbeventos.idCliente', '=', 'tbclientes.idCliente')
                ->select('tbeventos.*', 'tbclientes.nome','tbclientes.idCliente','tbclientes.email','tbclientes.telefone')
                ->where('dataEvento','=',$dataRegistroEvento)->orderBy('dataRegistroEvento','desc')->get();
        
        }else if(!empty($dataRegistroEvento) && !empty($nomeCliente)){
            $nomeCliente='%'.$nomeCliente.'%';
            
            $dadosEvento=DB::table('tbeventos')
                ->join('tbclientes', 'tbeventos.idCliente', '=', 'tbclientes.idCliente')
                ->select('tbeventos.*', 'tbclientes.nome','tbclientes.idCliente','tbclientes.email','tbclientes.telefone')
                ->where('dataEvento','=',$dataRegistroEvento)
                ->where('nome','LIKE',$nomeCliente)
                ->orderBy('dataRegistroEvento','desc')
                ->get();
    
        }else if(empty($dataRegistroEvento) && empty($nomeCliente)){
            $dadosEvento=DB::table('tbeventos')
            ->join('tbclientes', 'tbeventos.idCliente', '=', 'tbclientes.idCliente')
            ->select('tbeventos.*', 'tbclientes.nome','tbclientes.idCliente','tbclientes.email','tbclientes.telefone')
            ->orderBy('dataRegistroEvento','desc')
            ->get();
        }

        return $dadosEvento;
    }

    public function validator($dados){
        return Validator::make($dados,[
            'dataCliente'=>'date'
        ])->validate();
    }
}
