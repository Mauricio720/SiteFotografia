<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Artigo;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer('*',function($view) {
            $notificacoesEventos=$this->retornarNotificacaoEventos();
            $lembretesEventos=$this->retornarLembretesEventos();

            $notificacoesClientes=$this->retornarNotificacaoClientes();
            $notificacoesClientesEbook=$this->retornarNotificacaoClientesEbook();
            $notificacoesArquivosClientesEbook=$this->retornarNotificacaoArquivosBaixados();
            

            $notificacoesArtigosParaAprovar=$this->retornarNotificacaoArtigosParaAprovar();
            $notificacoesArtigosAprovados=$this->retornarNotificacaoArtigosAprovados();
            $notificacoesArtigosObservacoes=$this->retornarNotificacaoArtigosObservacoes();
            

            $numNotificacoes=$this->numNotificacoes($notificacoesEventos,
                $notificacoesClientes,$lembretesEventos
                ,$notificacoesArtigosParaAprovar,
                    $notificacoesArtigosAprovados,
                        $notificacoesArtigosObservacoes,$notificacoesClientesEbook,
                            $notificacoesArquivosClientesEbook);
            
            $view->with('user', Auth::user());
            $view->with('notificacoesEvento',$notificacoesEventos);
            $view->with('lembretesEvento',$lembretesEventos);
            $view->with('notificacoesClientes',$notificacoesClientes);
            $view->with('notificacoesClientesEbook',$notificacoesClientesEbook);
            $view->with('notificacoesArquivosClientesEbook',$notificacoesArquivosClientesEbook);
            
            $view->with('notificacoesArtigosObservacoes',$notificacoesArtigosObservacoes);


            $view->with('notificacoesArtigosParaAprovar',$notificacoesArtigosParaAprovar);
            $view->with('notificacoesArtigosAprovados',$notificacoesArtigosAprovados);
            $numNotificacoesGerais=0;
            $view->with('numNotificacoesTotal',$numNotificacoes);
            $view->with('numNotificacoesGeral',$numNotificacoesGerais);

            
            if(Auth::user()==null){
                return redirect()->route('login');
            }
            $eventoNotificacoesNumeros=count($notificacoesEventos) + count($lembretesEventos);
            $clientesNotificacoesNumeros=count($notificacoesClientes)+count($notificacoesClientesEbook);
            $artigosNotificacoesNumeros=+count($notificacoesArtigosObservacoes)+count($notificacoesArtigosAprovados);
            $artigoADMNotificacoesNumeros=count($notificacoesArtigosParaAprovar);
           

            $view->with('eventoNotificacaoNumeros',$eventoNotificacoesNumeros);
            $view->with('artigosNotificacaoNumeros',$artigosNotificacoesNumeros);
            $view->with('artigosADMNotificacaoNumeros',$artigoADMNotificacoesNumeros);
            
            $view->with('clienteNotificacaoNumeros',$clientesNotificacoesNumeros);
        });
    }

    private function retornarNotificacaoEventos(){
        $eventos=DB::table('tbeventos')
            ->join('tbclientes', 'tbeventos.idCliente', '=', 'tbclientes.idCliente')
            ->select('tbeventos.*', 'tbclientes.nome')
            ->where('tbeventos.notificacao',1)->get();
        
        $notificacoes=[];
        foreach($eventos as $evento){
            $notificacoes[]=[
                'idEvento'=>$evento->idEvento,
                'tipo'=>'Interesse de Evento!',
                'iconNotificacao'=>"",
                'msg'=>$evento->nome." demonstrou interesse de evento para o dia "
                    .date('d/m/y',strtotime($evento->dataEvento)),
            ];
        }

        return $notificacoes;
    }

    private function retornarNotificacaoClientes(){
        $clientes=DB::table('tbclientes')->where('notificacao',1)->get();
        $notificacoes=[];
        foreach($clientes as $cliente){
            $notificacoes[]=[
                'idCliente'=>$cliente->idCliente,
                'tipo'=>'Novo Cliente!',
                'iconNotificacao'=>"",
                'msg'=>$cliente->nome." se registrou pelo orçamento no dia"
                    .date('d/m/y',strtotime($cliente->dataCadastro)),
            ];
        }

        return $notificacoes;
    }

    private function retornarNotificacaoClientesEbook(){
        $clientes=DB::table('tbclientesebook')->where('notificacao',1)->get();
        $notificacoes=[];
        foreach($clientes as $cliente){
            $notificacoes[]=[
                'idClienteEbook'=>$cliente->idClienteEbook,
                'tipo'=>'Novo Cliente!',
                'iconNotificacao'=>"",
                'msg'=>$cliente->nome." se registrou para baixar um arquivo no dia"
                    .date('d/m/y',strtotime($cliente->dataCadastro)),
            ];
        }

        return $notificacoes;
    }

    private function retornarNotificacaoArquivosBaixados(){
        $arquivos=DB::table('tbclientesebook')
        ->join('tbarquivosclientes','tbclientesebook.idClienteEbook','tbarquivosclientes.idClienteEbook')
        ->join('tbarquivosartigos','tbarquivosclientes.idArquivoArtigo','tbarquivosartigos.idArquivoArtigo')
        ->select('tbclientesebook.*','tbarquivosclientes.*','tbarquivosartigos.*')
        ->where('tbarquivosclientes.notificacao',1)
        ->get();

        $notificacoes=[];
        foreach($arquivos as $arquivo){
            $notificacoes[]=[
                'idClienteEbook'=>$arquivo->idClienteEbook,
                'idArquivoArtigo'=>$arquivo->idArquivoArtigo,
                'tipo'=>'Novo Arquivo Baixado!',
                'iconNotificacao'=>"",
                'msg'=>$arquivo->nome." baixou o arquivo ".$arquivo->nomeArquivo." no dia "
                    .date('d/m/y',strtotime($arquivo->dataCadastro)),
            ];
        }

        return $notificacoes;
    }
    
    


    private function retornarNotificacaoArtigosParaRevisar(){
        $artigos=Artigo::join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->where('permissoes',"!=",'ADM')
        ->where('revisado',false)
         ->get();

        $notificacoes=[];
        foreach($artigos as $artigo){
            $notificacoes[]=[
                'idArtigo'=>$artigo->idArtigo,
                'tipo'=>'Novo Artigo Adicionado!',
                'iconNotificacao'=>"",
                'msg'=>"Você tem um novo artigo para revisar feito por ".$artigo->nome."
                    no dia ".date('d/m/y',strtotime($artigo->dataCriado)),
            ];
        }

        return $notificacoes;
    }

    
    private function retornarNotificacaoArtigosRevisados(){
        if(Auth::user()==null){
            return redirect()->route('login');
        }
        $artigos=Artigo::join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->where('permissoes',"!=",'ADM')
        ->where('notificacaoRevisado',true)
        ->where('tbartigos.idUsuario',Auth::user()->idUsuario)
         ->get();

        $notificacoes=[];
        foreach($artigos as $artigo){
            $notificacoes[]=[
                'idArtigo'=>$artigo->idArtigo,
                'tipo'=>'Artigo Revisado!',
                'iconNotificacao'=>"",
                'msg'=>"Seu artigo foi revisado pelo ADM, aguarde a aprovação!",
            ];
        }

        return $notificacoes;
    }

    private function retornarNotificacaoArtigosParaAprovar(){
        $artigos=Artigo::join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->where('aprovado',false)
        ->where('permissoes',"!=",'ADM')
        ->get();

        $notificacoes=[];
        foreach($artigos as $artigo){
            $notificacoes[]=[
                'idArtigo'=>$artigo->idArtigo,
                'tipo'=>'Artigo para aprovar!',
                'iconNotificacao'=>"",
                'msg'=>"Você tem um artigo para aprovar feito por ".$artigo->nome."
                    no dia ".date('d/m/y',strtotime($artigo->dataCriado)),
            ];
        }

        return $notificacoes;
    }

    private function retornarNotificacaoArtigosAprovados(){
        if(Auth::user()==null){
            return redirect()->route('login');
        }
        
        $artigos=Artigo::join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->where('notificacaoAprovado',true)
        ->where('permissoes',"!=",'ADM')
        ->where('tbartigos.idUsuario',Auth::user()->idUsuario)
        ->get();

        $notificacoes=[];
        foreach($artigos as $artigo){
            $notificacoes[]=[
                'slugArtigo'=>$artigo->slug,
                'tipo'=>'Seu Artigo foi aprovado!',
                'iconNotificacao'=>"",
                'msg'=>"Clique para ver seu artigo no site principal",
            ];
        }

        return $notificacoes;
    }

    
    private function retornarNotificacaoArtigosObservacoes(){
        if(Auth::user()==null){
            return redirect()->route('login');
        }
        
        $artigos=Artigo::join('tbusuarios','tbartigos.idUsuario','=','tbusuarios.idUsuario')
        ->select('tbartigos.*','tbusuarios.nome')
        ->where('notificacaoObservacao',true)
        ->where('permissoes',"!=",'ADM')
        ->where('observacao',"!=",'null')
        ->where('tbartigos.idUsuario',Auth::user()->idUsuario)
        ->get();

        $notificacoes=[];
        foreach($artigos as $artigo){
            $notificacoes[]=[
                'idArtigo'=>$artigo->idArtigo,
                'tipo'=>'Observação no Artigo!',
                'iconNotificacao'=>"",
                'msg'=>"Seu artigo teve uma observação inserida",
            ];
        }

        return $notificacoes;
    }

    private function retornarLembretesEventos(){
        $notificacoes=[];

        $eventos=DB::table('tbeventos')
            ->join('tbclientes', 'tbeventos.idCliente', '=', 'tbclientes.idCliente')
            ->select('tbeventos.*', 'tbclientes.nome')
            ->where('confirmar',0)
            ->get();

        
        
        foreach($eventos as $evento){
                $notificacoes[]=[
                    'idEvento'=>$evento->idEvento,
                    'tipo'=>'Lembrete Evento!',
                    'iconNotificacao'=>"",
                    'msg'=>"Formulario do cliente ".$evento->nome.
                            " ainda  não foi lido",
                ];
            }
         
        
        return $notificacoes;
    }

    private function numNotificacoes($notificacoesEventos,$notificacoesClientes,
        $lembretesEventos,$notificacoesArtigosParaAprovar,$notificacoesArtigosAprovados,
        $notificacoesArtigosObservacoes,$notificacoesClientesEbook,
        $notificacoesArquivosClientesEbook){
        if(Auth::user()==null){
            return redirect()->route('login');
        }

        $numNotificacoesEventos=count($notificacoesEventos);
        $numNotificacoesClientes=count($notificacoesClientes);
        $numLembretesEventos=count($lembretesEventos);
        
        $notificacoesArtigosParaAprovar=count($notificacoesArtigosParaAprovar);
        $notificacoesArtigosAprovados=count($notificacoesArtigosAprovados);
        $notificacoesArtigosObservacoes=count($notificacoesArtigosObservacoes);
        $notificacoesClientesEbook=count($notificacoesClientesEbook);
        $notificacoesArquivosClientesEbook=count($notificacoesArquivosClientesEbook);

        $totalNotificacoes=$numNotificacoesEventos+$numNotificacoesClientes
            +$numLembretesEventos+$notificacoesArtigosParaAprovar
                    +$notificacoesArtigosAprovados+$notificacoesArtigosObservacoes
                        +$notificacoesClientesEbook+$notificacoesArquivosClientesEbook;
        return $totalNotificacoes;
    }
    
}
