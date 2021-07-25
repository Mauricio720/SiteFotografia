<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Artigo;


class ArtigosController extends Controller
{
    public function __invoke(){
       $dadosArtigo=Artigo::orderBy('dataCriado','desc')
        ->orderBy('horaCriado','desc')
        ->where('aprovado',true)
        ->get();
        
        return view('Site.artigos',['selectedMenu'=>'Artigos',
            'dadosArtigo'=>$dadosArtigo,'tituloDescricao'=>""]);
    }

    public function verArtigo($slugArtigo,$notificacao=""){
       $artigo=Artigo::where('slug',$slugArtigo)
                ->first();
        $arquivosArtigos=DB::table('tbarquivosartigos')
            ->join('tbartigos','tbarquivosartigos.idArtigo','=','tbartigos.idArtigo',)
            ->select('tbarquivosartigos.*','tbartigos.tituloArtigo')
            ->where('tbarquivosartigos.idArtigo',$artigo->idArtigo)
            ->get();
        
        $outrosArtigos=DB::table('tbartigos')
            ->where('tbartigos.idArtigo','!=',$artigo->idArtigo)
            ->where('aprovado',1)
            ->get();    

        if($artigo !=null){
            if($notificacao!=""){
                $artigo->notificacaoAprovado=0;
                $artigo->save();
            }    
            return view('Site.verArtigo',['artigo'=>$artigo,
                'arquivosArtigos'=>$arquivosArtigos,
                'outrosArtigos'=>$outrosArtigos]);
            
        }

        return redirect()->route('artigosSite');
    }
}
