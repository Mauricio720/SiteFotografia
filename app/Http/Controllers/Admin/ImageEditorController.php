<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use DOMDocument;

class ImageEditorController extends Controller
{
    public function uploadImage($idArtigo,Request $request){
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png'
        ]);
        
        $artigo=DB::table('tbartigos')->where('idArtigo',$idArtigo)->first(); 

        $caminho=$artigo->urlArtigo.'/fotosArtigo/';

        if(!file_exists($caminho)) {
            Storage::makeDirectory($caminho);
        }
        
        $imageName = $request->file->getClientOriginalName();
        $caminhoCompleto=$caminho.$imageName;
        DB::table('tbimagensartigo')->insert(['urlImagem'=>$caminhoCompleto,
                'idArtigo'=>$idArtigo,'nomeImagem'=>$imageName]);
        
        $request->file('file')->storeAs($caminho,$imageName);

        return [
            'location' => asset('storage/'.$caminho.$imageName),
        ];
    }

    
}

