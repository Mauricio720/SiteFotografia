<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\ConfigSite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $dadosConfig=ConfigSite::all();
        $dadosView['menus']=DB::select("SELECT * FROM tbmenus");
        
        if(count($dadosConfig) > 0){
            foreach($dadosConfig as $dado){
                $dadosView[$dado['titulo']]=$dado['valor'];
            }
        }

        View::share($dadosView);
  
        
     
    }

}
