<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Foto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class UsuariosController extends Controller
{
    public function __construct(){
        
    }

    public function __invoke(){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');
        $dadosUsuarios['dadosUser']=User::where('idUsuario',Auth::user()->idUsuario)->first();
        $dadosUsuarios['permissoes']=explode('/',Auth::user()->permissoes);
        $dadosUsuarios['selectedMenu']='Usuarios';
        return view('Admin.meuPerfil',$dadosUsuarios);
    }

    public function allUsuariosView(){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');
        $dadosUsuarios['dadosUsuarios']=User::where('ativo',1)
            ->where('permissoes',"!=",'ADM')
                ->where('idUsuario',"!=",Auth::user()->idUsuario)
                ->get();
        
        $dadosUsuarios['selectedMenu']='Usuarios';
        return view('Admin.usuarios',$dadosUsuarios);
    }

    public function cadastrarUsuario(Request $request){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');
        
        $dados=$request->only(['nome','email','permissoes']);
        $this->validator($dados);
        
        if(empty($dados['permissoes'])){
            return redirect()->route('usuariosPainel')->withErrors('Selecione alguma permissão');
        }


        if($request->has(['nome','email','permissoes'])){
            $nome=$dados['nome'];
            $email=$dados['email'];
            $permissoes=$dados['permissoes'];
            $todasPermissoes="";
            
            foreach ($permissoes as $permissao) {
                $todasPermissoes=$todasPermissoes."/".$permissao;
            }
        
        $tokenAccess = bcrypt(date('YmdHms'));


        $usuario=new User();
        $usuario->nome=$nome;
        $usuario->email=$email;
        $usuario->permissoes=$todasPermissoes;
        $usuario->fotoPerfil="user.png";
        $usuario->password=md5(rand(0,9999).rand(0,9999)).md5(strtotime(rand(0,9999)));
        $usuario->token=$tokenAccess;
        $usuario->save();

        $hash=md5($usuario->idUsuario);
        $link=route('ativarContaUsuario',['hash'=>$hash]);
        $this->enviarEmail($nome,$email,$link);
        return redirect()->route('usuariosPainel')
            ->with('success','Cadastro realizado com sucesso! Ative a conta com o link enviado no email');;    
        
        }
    }

    public function editarUsuario(Request $request){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');

        $dados=$request->only(['idUsuario','nome','email','senha','fotoPerfil','emailAlterado']);
        $this->validatorAtualizar($dados);
        
        $user=User::where('email',$dados['email'])->first();

        if($user!=null && $dados['emailAlterado']=="true"){
            return redirect()->route('meuPerfilPainel')->withErrors('Esse email ja está sendo usado');
        }

        if($request->has(['idUsuario','nome','email','senha'])){
            
            $usuario=User::find($dados['idUsuario']);
            $usuario->nome=$dados['nome'];
            $usuario->email=$dados['email'];
            
            if($usuario->password!=$dados['senha']){
                $usuario->password=Hash::make($dados['senha']);
            }
            
            
        if(!empty($dados['fotoPerfil'])){
                $fotoPerfil=$usuario->fotoPerfil;
                if($fotoPerfil!='user.png'){
                    Storage::delete('imagens/fotoPerfil/'.$fotoPerfil);
                }
                $image=md5(time().(rand(0,9999).md5(time()))).".".$request->file('fotoPerfil')
                ->extension();
                $request->file('fotoPerfil')->storeAs('imagens/fotoPerfil/',$image);
                $usuario->fotoPerfil=$image;
            }

            $usuario->save();

           return redirect()->route('meuPerfilPainel');
        }
    }

    public function deleteUsuario($idUsuario){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');

        $fotos=Foto::where('idUsuario',$idUsuario)->get();
        $album=DB::table('tbalbumfoto')->where('idUsuario',"=",$idUsuario)->get();
        $user=User::find($idUsuario);
       
        if(count($fotos)>0 || count($album)>0){
            return redirect()->route('usuariosPainel')->withErrors("Não é possivel deletar, pois há algum album e/ou foto utilizando esse usuario!");
        }else{
            if($user->fotoPerfil !="user.png"){
                Storage::delete('imagens/fotoPerfil/'.$user->fotoPerfil);
            }
            $user->delete();
        }

        return redirect()->route('usuariosPainel');
    }

    public function mudarPermissaoView($usuario){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');

        $usuario=User::where('idUsuario',$usuario)->first();
        $permissoes=explode('/',$usuario->permissoes);
        return view('Admin.mudarPermissao',
            ['usuario'=>$usuario,'permissoes'=>$permissoes,'selectedMenu'=>'Usuarios']);
    }

    public function atualizarPermissoes(Request $request){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');

        $dados=$request->only(['permissoes','idUsuario']);
        $this->validatorPermissoes($dados);
        
        if(empty($dados['permissoes'])){
            return redirect()->route('mudarPermissaoView')->withErrors('Selecione alguma permissão');
        }

        if($request->has(['permissoes'])){
            $permissoes=$dados['permissoes'];
            $todasPermissoes="";
            
            foreach ($permissoes as $permissao) {
                $todasPermissoes=$todasPermissoes."/".$permissao;
            }
            $tokenAccess = bcrypt(date('YmdHms'));

            $usuario=User::find($dados['idUsuario']);
            $usuario->permissoes=$todasPermissoes;
            $usuario->token=$tokenAccess;
            $usuario->save();
        }

        return redirect()->route('usuariosPainel');
    }
    
    public function lembrarSenhaView(){
        return view('Admin.lembrarSenha');
    }

    public function lembrarSenha(Request $request){
        $dados=$request->only(['nome','email']);
        $this->validatorLembrarSenha($dados);

        if($request->has(['nome','email'])){
            $nome=$dados['nome'];
            $email=$dados['email'];

            $user=User::where('nome',"=",$nome)->where('email',"=",$email)->first();
            
            if($user!=null){
               $hash=md5(rand(0,9999).rand(0,9999).strtotime('NOW'));
               $userToken=DB::table('tbusuariotoken')
                    ->insert(['hash'=>$hash,'idUsuario'=>$user->idUsuario,
                        'expiradoEm'=>date('Y-m-d H:i', strtotime('+1 days')),
                            'ativo'=>1]);

               $link=route('atualizarSenhaRelembrar',['hash'=>$hash]);
               
               $this->enviarEmailAtualizarSenha($nome,$email,$link);
                
                return redirect()->route('lembrarSenha')
                    ->with('success','Um link para atualizar a senha foi enviado para seu email');
                
            }else{
                return redirect()->route('lembrarSenha')->withErrors('Nome e/ou Email não encontrado');
            }
        }
    }

    public function atualizarSenhaRelembrar($hash){
        if(!empty($hash)){
            $usuario=DB::table('tbusuariotoken')->where('hash',$hash)
                ->where('expiradoEm',">=",date('y-m-d'))
                ->where('ativo',1)
                ->first();

            if($usuario != null){
                return view('Admin.atualizarSenha',['idUsuario'=>$usuario->idUsuario,'relembrar'=>true]);
            }else{
                echo "LINK INVÁLIDO OU EXPIRADO!!!";
            }
        }
    }

    public function ativarConta($hash){
        if(!empty($hash)){
            $usuario=DB::select('SELECT * FROM tbusuarios
                 WHERE md5(idUsuario)=:hash AND ativo=:ativo'
                ,[':hash'=>$hash,':ativo'=>0]);
            
            if(empty($usuario)){
                echo "LINK INVALIDO OU JA UTILIZADO!";
            }else{
                $user=User::where($usuario[0]->idUsuario);
                
                if(!empty($usuario)){
                    return view('Admin.atualizarSenha',['idUsuario'=>$usuario[0]->idUsuario,
                        'selectedMenu'=>'Usuarios']);
                }else{
                    echo "LINK INVÁLIDO";
                }
            }
        }
    }

    public function enviarCodigoConfirmacaoEmail(Request $request){
        $this->middleware('auth');
        $this->middleware('auth.unique.user');
        
        if($request->has(['codigoEmail','email'])){
            $dados=$request->all();
            $codigo=$dados['codigoEmail'];
            $email=$dados['email'];

            $this->enviarCodigoEmail($email,$codigo);
        }
    }

    public function atualizarSenha(Request $request){
        $dados=$request->only(['idUsuario','senha','confirmarSenha']);
        $this->validatorSenha($dados);

        if($request->has(['idUsuario','senha','confirmarSenha'])){
            $usuario=User::find($dados['idUsuario']);
            $usuario->password=(Hash::make($dados['senha']));
            $usuario->ativo=1;
            $usuario->save();

            $userToken=DB::table('tbusuariotoken')
                ->where('idUsuario',$usuario->idUsuario)->first();
            if($userToken != null){
                DB::table('tbusuariotoken')
                    ->where('idUsuario',$userToken->idUsuario)
                    ->update(['ativo'=>0]);
            }
                

            return redirect()->route('login');
        }
    }

    private function enviarEmail($nome,$email,$link){
        $emailDestino=$email;
        $emailEnvio=DB::table('tbconfigsite')->where('titulo','=','emailContato')->first('valor');
        $emailEnvio=$emailEnvio->valor;
        $assunto="Ativação de conta";
        $assunto='=?UTF-8?B?'.base64_encode($assunto).'?=';
        $corpo="Nome: ".$nome."\r\n".
            "Email: ".$email."\r\n".
            "Clique nesse link para ativar sua conta:"."\r\n".
            'Link: '.$link;
        $cabecalho="From:".$emailEnvio."\r\n".
                    "Reply-To: ".$emailEnvio."\r\n".
                    "X-Mailer: PHP/".phpversion();
        mail($emailDestino, $assunto,$corpo,$cabecalho);
    
    }

    private function enviarEmailAtualizarSenha($nome,$email,$link){
        $emailDestino=$email;
        $emailEnvio=DB::table('tbconfigsite')->where('titulo','=','emailContato')->first('valor');
        $emailEnvio=$emailEnvio->valor;
        $assunto="Atualização de Senha";
        $assunto='=?UTF-8?B?'.base64_encode($assunto).'?=';
        $corpo="Nome: ".$nome."\r\n".
            "Email: ".$email."\r\n".
            "Clique nesse link para atualizar sua senha:"."\r\n".
            'Link: '.$link;
        $cabecalho="From:".$emailEnvio."\r\n".
                    "Reply-To: ".$emailEnvio."\r\n".
                    "X-Mailer: PHP/".phpversion();
        mail($emailDestino, $assunto,$corpo,$cabecalho);
    
    }

    private function enviarCodigoEmail($email,$codigo){
        $emailDestino=$email;
        $emailEnvio=DB::table('tbconfigsite')->where('titulo','=','emailContato')->first('valor');
        $emailEnvio=$emailEnvio->valor;
        $assunto="Confirmação de email";
        $assunto='=?UTF-8?B?'.base64_encode($assunto).'?=';
        $corpo="Email: ".$email."\r\n".
            "Codigo para alterar seu email"."\r\n".
            'Codigo:'.$codigo;
        $cabecalho="From:".$emailEnvio."\r\n".
                    "Reply-To: ".$emailEnvio."\r\n".
                    "X-Mailer: PHP/".phpversion();
        mail($emailDestino, $assunto,$corpo,$cabecalho);
    
    }

    private function validatorSenha($dados){
        return Validator::make($dados,[
            'senha'=>['required','string'],
            'confirmarSenha'=>['required','string'],
            'idUsuario'=>['required'],
        ])->validate();
    }

    private function validator($dados){
        return Validator::make($dados,[
            'nome'=>['required','string'],
            'email'=>['required','email','string','unique:tbusuarios'],
        ])->validate();
    }
    
    private function validatorPermissoes($dados){
        return Validator::make($dados,[
            'permissoes'=>['required']
        ])->validate();
    }

    private function validatorLembrarSenha($dados){
        return Validator::make($dados,[
            'nome'=>['required','string'],
            'email'=>['required','email','string'],
        ])->validate();
    }


    private function validatorAtualizar($dados){
        return Validator::make($dados,[
            'nome'=>['required','string'],
            'email'=>['required','email','string'],
            'senha'=>['required','string']
        ])->validate();
    }
 
}
