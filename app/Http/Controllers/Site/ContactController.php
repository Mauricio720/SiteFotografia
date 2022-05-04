<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Evento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ContactController extends Controller
{
    public function __invoke(){
        $dataAtual=Carbon::now()->format('Y-m-d');
        return view('Site.contato',['dataAtual'=>$dataAtual]);
    }

 
     public function cadastrarEventoECliente(Request $request){
        $dadosPOST=$request->only(['nome','email','telefone','descricaoEvento'
            ,'dataEvento','comoEncontrou']);
        $dataAtual=Carbon::now()->format('Y-m-d');    
        
        $this->validator($dadosPOST,$dataAtual);
        
        if($request->has(['nome','email','telefone','descricaoEvento'
        ,'dataEvento'])){
            $nome=$request->input('nome');
            $email=$request->input('email');
            $telefone=$request->input('telefone');
            $descricaoEvento=$request->input('descricaoEvento');
            $dataEvento=$request->input('dataEvento');
            $comoEncontrou=$request->input('comoEncontrou');
           
            if($this->verificarEmailExistente($email) != null && $request->missing('idCliente')){
                $dataAtual=Carbon::now()->format('Y-m-d');
                $cliente=Cliente::where('email',$email)->first();   
                return view('Site.contato',['emailJaRegistrado'=>true,
                    'dataAtual'=>$dataAtual,'cliente'=>$cliente,
                        'descricaoEvento'=>$descricaoEvento,
                            'dataEvento'=>$dataEvento,
                                'comoEncontrou'=>$comoEncontrou]);      
            }
           
            if($request->has('idCliente')){
                $idCliente=$request->input('idCliente');
                $this->cadastrarEvento($idCliente,$dataEvento,$descricaoEvento,$comoEncontrou);
                $this->atualizarCliente($idCliente,$nome,$email,$telefone);
                $this->enviarEmail($nome,$email,$descricaoEvento,$comoEncontrou,$telefone,$dataEvento);
            }else{
                $this->cadastrarCliente($nome,$email,$telefone);
                $this->cadastrarEvento(DB::getPdo()->lastInsertId(),$dataEvento,$descricaoEvento,$comoEncontrou);
                $this->enviarEmail($nome,$email,$descricaoEvento,$comoEncontrou,$telefone,$dataEvento);
            }
        }    
        return redirect()->route('contato')->with('success','Agradecemos o interesse, entraremos em contato em breve!');
     
    }

    private function validator($dados,$dataAtual){
        return $validator=Validator::make($dados,[
            'nome'=>['required','string','max:100'],
            'email'=>['required','string','email','max:300'],
            'telefone'=>['required','string'],
            'descricaoEvento'=>['required','string'],
            'dataEvento'=>['required','string','date','after_or_equal:'.$dataAtual],
        ])->validate($dados);
    }

    private function cadastrarCliente($nome,$email,$telefone){
        $cliente=new Cliente();
        $cliente->nome=$nome;
        $cliente->email=$email;
        $cliente->telefone=$telefone;
        $cliente->dataCadastro=Carbon::now();
        $cliente->horaCadastro=Carbon::now();
        $cliente->notificacao=1;
        $cliente->save();
    }

    private function atualizarCliente($idCliente,$nome,$email,$telefone){
        $cliente=Cliente::find($idCliente);
        $cliente->nome=$nome;
        $cliente->email=$email;
        $cliente->telefone=$telefone;
       
        $cliente->save();
    }

    private function cadastrarEvento($idCliente,$dataEvento,$descricaoEvento,$comoEncontrou=""){
            $evento=new Evento();
            $evento->idCliente=$idCliente;
            $evento->dataEvento=$dataEvento;
            $evento->descricaoEvento=$descricaoEvento;
            $evento->comoEncontrou=$comoEncontrou;
            $evento->confirmar=0;
            $evento->notificacao=1;
            $evento->dataRegistroEvento=Carbon::now();
            $evento->horaRegistroEvento=Carbon::now();
            $evento->save();
    }

    private function verificarEmailExistente($email){
        $cliente=Cliente::where('email',$email)->first();
        $idCliente="";
        if($cliente!=null){
            $idCliente=$cliente->idCliente;
        }

        return $idCliente;
    }

    private function enviarEmail($nome,$email,$mensagem,$comoEncontrou,$numTelefone,$dataEvento){
        if(!empty($nome) && !empty($email) && !empty($mensagem) && !empty($comoEncontrou)){
            $nome=$nome;
            $email=$email;
            $mensagem=$mensagem;
            $emailDestino=DB::table('tbconfigsite')->where('titulo','=','emailContato')->first('valor');
            $emailDestino=$emailDestino->valor;
            $assunto="Interesse de Evento";
            $corpo="Nome: ".$nome."\r\n".
                    "Email: ".$email."\r\n".
                    "Num de Telefone: ".$numTelefone."\r\n".
                    "Data Evento: ".date('d/m/yy',strtotime($dataEvento))."\r\n".
                    "Como Encontrou: ".$comoEncontrou."\r\n".
                    "Mensagem: ".$mensagem;
            $cabecalho="From:".$email."\r\n".
                        "Reply-To: ".$email."\r\n".
                        "X-Mailer: PHP/".phpversion();
            mail($emailDestino, $assunto,$corpo,$cabecalho);
		
    	}
    }
}
