<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Foto;
use App\ConfigSite;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $dadosView=[];
        $dadosView['favoritePictures']=Foto::where('favorita',1)->orderBy('dataFavoritada','desc')
            ->orderBy('horaFavoritada','desc')->get();
        $dadosView['depoimentos']=DB::table('tbdepoimentos')->get();
        return view('Site.home',$dadosView);
    }
}
