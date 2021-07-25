<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;



class ClienteController extends Controller
{
    
    public function clienteEbook($nomeArquivo){
        $arquivo=DB::table('tbarquivosartigos')->where('nomeArquivo',$nomeArquivo)->first();
        return view('Site.clienteEbook',['idArquivo'=>$arquivo->idArquivoArtigo]);
    }

    public function cadastrarClienteEbook(Request $request){
        $dados=$request->only(['nome','email','telefone','idArquivo','idClienteEbook','confirmar']);
        
        $validator=$this->validator($dados);
        
        if($request->has(['nome','email','telefone','idArquivo'])){
            
            $clienteEbook=DB::table('tbclientesebook')
            ->where('email',$dados['email'])
            ->get();

            $arquivo=DB::table('tbarquivosartigos')
                ->where('idArquivoArtigo',$dados['idArquivo'])
                ->first();
            
            if(count($clienteEbook)==0 && empty($dados['confirmar'])){
                DB::table('tbclientesebook')->insert(['nome'=>$dados['nome'],
                    'email'=>$dados['email'],'telefone'=>$dados['telefone'],
                    'notificacao'=>true,'dataCadastro'=>Carbon::now(),
                    'horaCadastro'=>Carbon::now()]);
            
                DB::table('tbarquivosclientes')
                    ->insert(['idClienteEbook'=>DB::getPdo()->lastInsertId(),
                    'idArquivoArtigo'=>$arquivo->idArquivoArtigo,
                    'dataBaixado'=>Carbon::now(),
                    'horaBaixado'=>Carbon::now(),
                    'notificacao'=>1]);

                    return redirect()->route('baixarArquivoView',
                        ['nomeArquivo'=>$arquivo->nomeArquivo]);
            }else{
                if($request->has(['confirmar'])){
                    DB::table('tbclientesebook')
                    ->where('idClienteEbook',$dados['idClienteEbook'])
                    ->update(['nome'=>$dados['nome'],
                    'email'=>$dados['email'],'telefone'=>$dados['telefone']]);

                    DB::table('tbarquivosclientes')
                    ->insert(['idClienteEbook'=>$dados['idClienteEbook'],
                        'idArquivoArtigo'=>$arquivo->idArquivoArtigo,
                        'dataBaixado'=>Carbon::now(),
                        'horaBaixado'=>Carbon::now(),
                        'notificacao'=>1    
                        ]);
                
                return redirect()->route('baixarArquivoView',
                    ['nomeArquivo'=>$arquivo->nomeArquivo]);
                
                }else{
                    return view('Site.clienteEbook',
                        ['idArquivo'=>$dados['idArquivo'],
                        'clienteDados'=>$clienteEbook,
                        'idClienteEbook'=>$clienteEbook[0]->idClienteEbook]);
                    
                }
            }    
        }
    }

    public function baixarArquivoView($nomeArquivo){
        $arquivo=DB::table('tbarquivosartigos')->where('nomeArquivo',$nomeArquivo)->first();
        return view('Site.baixarArtigo',['arquivo'=>$arquivo]);
    }

    public function baixarArquivoArtigo($nomeArquivo){

        $arquivo=DB::table('tbarquivosartigos')
        ->where('nomeArquivo',$nomeArquivo)
        ->first();
        
        return Storage::download($arquivo->urlArquivo);    

    }

    public function validator($dados){
        return Validator::make($dados,[
            'nome'=>['required','string'],
            'email'=>['required','string','email','tbclientesebook.unique'],
            'telefone'=>['required','string']
        ]);
    }
}
