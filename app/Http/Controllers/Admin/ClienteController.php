<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class ClienteController extends Controller
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
      
      $clientes=in_array("Clientes",$permissoes);   
      
      if($adm==false && $admSegundario==false && $clientes==false){
          return true;
      }else{
         return false;
      }
   }
   
   public function __invoke(){
       $dadosClientes=DB::select("SELECT *, (SELECT COUNT(*) FROM tbeventos WHERE idCliente=tbclientes.idCliente) AS 'quantidadeEventos'
       FROM tbclientes");
       return view('Admin.clientes',['dadosClientes'=>$dadosClientes,
            'nomeCliente'=>'','selectedMenu'=>'Clientes']);
   }

   public function clienteEbookView($idClienteEbook="",$idArquivoArtigo=""){
      $dadosClientes=DB::table('tbclientesebook')
      ->join('tbarquivosclientes','tbclientesebook.idClienteEbook','tbarquivosclientes.idClienteEbook')
      ->join('tbarquivosartigos','tbarquivosclientes.idArquivoArtigo','tbarquivosartigos.idArquivoArtigo' )
      ->select('tbclientesebook.*','tbarquivosclientes.*','tbarquivosartigos.*')
      ->orderBy('dataBaixado','ASC')
      ->get();

      if($idClienteEbook!="" && $idArquivoArtigo==""){
         $dadosClientesNotificacao=DB::table('tbclientesebook')
         ->join('tbarquivosclientes','tbclientesebook.idClienteEbook','tbarquivosclientes.idClienteEbook')
         ->join('tbarquivosartigos','tbarquivosclientes.idArquivoArtigo','tbarquivosartigos.idArquivoArtigo' )
         ->select('tbclientesebook.*','tbarquivosclientes.*','tbarquivosartigos.*')
         ->where('tbclientesebook.idClienteEbook',$idClienteEbook)
         ->first();

         DB::table('tbclientesebook')
         ->where('tbclientesebook.idClienteEbook',$idClienteEbook)
         ->update(['notificacao'=>0]);

         return view('Admin.clientesEbook',['dadosClientes'=>$dadosClientes,
            'dadosClientesNotificacao'=>$dadosClientesNotificacao,
            'nomeCliente'=>'','selectedMenu'=>'Clientes']);   
      
      }else if($idArquivoArtigo!=""){
         $dadosClientesNotificacao=DB::table('tbclientesebook')
         ->join('tbarquivosclientes','tbclientesebook.idClienteEbook','tbarquivosclientes.idClienteEbook')
         ->join('tbarquivosartigos','tbarquivosclientes.idArquivoArtigo','tbarquivosartigos.idArquivoArtigo' )
         ->select('tbclientesebook.*','tbarquivosclientes.*','tbarquivosartigos.*')
         ->where('tbclientesebook.idClienteEbook',$idClienteEbook)
         ->where('tbarquivosartigos.idArquivoArtigo',$idArquivoArtigo)
         ->first();

         DB::table('tbarquivosclientes')
         ->where('idArquivoArtigo',$idArquivoArtigo)
         ->update(['notificacao'=>0]);
         
         return view('Admin.clientesEbook',['dadosClientes'=>$dadosClientes,
            'dadosClientesNotificacao'=>$dadosClientesNotificacao,
            'nomeCliente'=>'','selectedMenu'=>'Clientes']);
      }
      return view('Admin.clientesEbook',['dadosClientes'=>$dadosClientes,
           'nomeCliente'=>'','selectedMenu'=>'Clientes']);  
   }

   public function clienteEbookPesquisar(Request $request){
      $dados=$request->only('nomeEmailCliente');

      if($request->has('nomeEmailCliente')){
         $nomeEmail='%'.$dados['nomeEmailCliente'].'%';
         
         $dadosClientes= $dadosClientes=DB::table('tbclientesebook')
         ->join('tbarquivosclientes','tbclientesebook.idClienteEbook','tbarquivosclientes.idClienteEbook')
         ->join('tbarquivosartigos','tbarquivosclientes.idArquivoArtigo','tbarquivosartigos.idArquivoArtigo' )
         ->select('tbclientesebook.*','tbarquivosclientes.*','tbarquivosartigos.*')
         ->where('nome','LIKE',$nomeEmail)
         ->orWhere('email','LIKE',$nomeEmail)
         ->orderBy('dataBaixado','ASC')
         ->get();
         
         return view('Admin.clientesEbook',['dadosClientes'=>$dadosClientes,
            'nomeCliente'=>$dados['nomeEmailCliente'],'selectedMenu'=>'Clientes']);
      }
   }

   public function clientesPesquisar(Request $request){
      $dados=$request->only('nomeEmailCliente');

      if($request->has('nomeEmailCliente')){
         $nomeEmail='%'.$dados['nomeEmailCliente'].'%';
         
         $dadosClientes=DB::select("SELECT *, (SELECT COUNT(*) FROM tbeventos WHERE idCliente=tbclientes.idCliente) AS 'quantidadeEventos'
            FROM tbclientes WHERE nome LIKE :nome OR email LIKE :email",
               [':nome'=>$nomeEmail,'email'=>$nomeEmail]);
         return view('Admin.clientes',['dadosClientes'=>$dadosClientes,
            'nomeCliente'=>$dados['nomeEmailCliente'],'selectedMenu'=>'Clientes']);
      }
   }

   public function clientesViewNotificacao($idCliente){
      $dadosClientes=DB::select("SELECT *, (SELECT COUNT(*) FROM tbeventos WHERE idCliente=tbclientes.idCliente) AS 'quantidadeEventos'
      FROM tbclientes");

      $dadosClientesNotificacao=DB::select("SELECT *, (SELECT COUNT(*) FROM tbeventos WHERE idCliente=tbclientes.idCliente) AS 'quantidadeEventos'
         FROM tbclientes WHERE idCliente=:idCliente",[':idCliente'=>$idCliente]);

      $evento=DB::table('tbclientes')->where('idCliente',$idCliente)
         ->update(['notificacao' => 0]);;


      return view('Admin.clientes',['dadosClientes'=>$dadosClientes,'nomeCliente'=>''
         ,'dadosClientesNotificacao'=>$dadosClientesNotificacao, 'selectedMenu'=>'Clientes']);

   }

   public function depoimentosView(){
      $dadosDepoimentos=DB::table('tbdepoimentos')->get();
         
      return view('Admin.depoimentos',['selectedMenu'=>'Clientes',
         'depoimentos'=>$dadosDepoimentos]);
   }

   public function addDepoimento(Request $request){
      $dados=$request->only(['depoimento','autor']);
      $request->validate([
         'depoimento'=>['required','string'],
         'autor'=>['required','string']
      ],$dados);
      
      if($request->has('autor','depoimento')){
         DB::table('tbdepoimentos')->insert(['depoimento'=>$dados['depoimento'],
            'autor'=>$dados['autor'],'dataDepoimento'=>Carbon::now()
               ,'horaDepoimento'=>Carbon::now(),'idUsuario'=>Auth::user()->idUsuario]);
         
         return redirect()->route('depoimentosView');
      }
   }

   public function editDepoimento(Request $request){
      $dados=$request->only(['depoimento','autor','idDepoimento']);
      $request->validate([
         'depoimento'=>['required','string'],
         'autor'=>['required','string'],
         'depoimento'=>['required']
      ],$dados);
      
      $depoimento=DB::table('tbdepoimentos')
      ->where('idDepoimento',$dados['idDepoimento'])
      ->first();

      if($request->has('autor','depoimento','depoimento') && $depoimento != null){
         DB::table('tbdepoimentos')->where('idDepoimento',$dados['idDepoimento'])
            ->update(['depoimento'=>$dados['depoimento'],
            'autor'=>$dados['autor']]);
      }

      return redirect()->route('depoimentosView');
   }

   public function excluirDepoimento($idDepoimento){
      $depoimento=DB::table('tbdepoimentos')->where('idDepoimento',$idDepoimento)->first();
      
      if($depoimento!=null){
         DB::table('tbdepoimentos')->where('idDepoimento',$idDepoimento)->delete();
      }

      return redirect()->route('depoimentosView');
   }
}
