<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Foto;
use Illuminate\Support\Facades\DB;



class FotoController extends Controller
{
    public function __invoke(){
        $dadosArray=[];
        $dadosArray['albuns']=DB::table('tbalbumfoto')
            ->join('tbcategoriaalbum','tbalbumfoto.idcategoria','=','tbcategoriaalbum.idcategoria')
            ->join('tbusuarios','tbalbumfoto.idUsuario','=','tbusuarios.idUsuario')
            ->select('tbalbumfoto.*','tbcategoriaalbum.*','tbusuarios.*')
            ->orderBy('dataCriacao','desc')
            ->orderBy('horaCriacao','desc')
            ->get(); 
        
        $dadosArray['category']=DB::select("SELECT * FROM tbcategoriaalbum");
        return view('Site.Portfolio',$dadosArray);
    }
    
    public function getAllFavoritePictures(){
        $pictures=Foto::where('favorita',1)->orderBy('dataFavoritada','desc')->orderBy('horaFavoritada','desc')->get();    
        return json_encode($pictures);
    }

    public function picturesFromAlbum($slugCategoria,$slugAlbum){
        $dadosArray=[];   
        
        $album=DB::table('tbalbumfoto')->where('slug','=',$slugAlbum)->first();
        $dadosArray['album']=$album;
        $dadosArray['picturesFromAlbum']=Foto::where('idAlbum',$album->idAlbum)->get(); 
        
        $dadosArray['albuns']=DB::select("SELECT * FROM tbalbumfoto INNER JOIN tbcategoriaalbum
        ON tbalbumfoto.idCategoria=tbcategoriaalbum.idCategoria 
            WHERE tbalbumfoto.idCategoria=:idCategoria AND idAlbum != :idAlbum",
                [':idCategoria'=>$album->idCategoria,'idAlbum'=>$album->idAlbum]);
        
        
        $view=DB::table('tbalbumfoto')->where('idAlbum',$album->idAlbum)->first();
        $view=$view->view+1;
        DB::table('tbalbumfoto')->where('idAlbum',$album->idAlbum)->update(['view'=>$view]);    

        $dadosArray['fichaTecnica']=DB::table('tbfichatecnica')
                ->where('idAlbum', '=', $album->idAlbum)->first('html');         
        $dadosArray['fichaTecnica']=$dadosArray['fichaTecnica']->html; 

        $dadosArray['nomeCategoria']=DB::table('tbcategoriaalbum')
                    ->where('idCategoria','=',$album->idCategoria)->first('nomeCategoria');
        $dadosArray['nomeCategoria']=$dadosArray['nomeCategoria']->nomeCategoria;

        $dadosArray['slugCategoria']=$slugCategoria;
        return view('Site.album',$dadosArray);      
    }

    
    
    public function likeAlbum(Request $request){
        $idAlbum=$request->only('idAlbum');
        $like=DB::table('tbalbumfoto')->where('idAlbum',$idAlbum)->first();
        $like=$like->curtida+1;
        DB::table('tbalbumfoto')
        ->where('idAlbum',$idAlbum)
        ->update(['curtida'=>$like]);
    }

    public function deslikeAlbum(Request $request){
        $idAlbum=$request->only('idAlbum');
        $like=DB::table('tbalbumfoto')->where('idAlbum',$idAlbum)->first();
        $like=$like->curtida-1;
        DB::table('tbalbumfoto')
        ->where('idAlbum',$idAlbum)
        ->update(['curtida'=>$like]);
    }
}
