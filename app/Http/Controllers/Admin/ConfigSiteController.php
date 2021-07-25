<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ConfigSite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class ConfigSiteController extends Controller
{
    public function atualizarConfigMenus(Request $request){
        
        if($request->has(['menu-1','menu-2','menu-3','menu-4','menu-5'])){
            $dados=$request->only(['menu-1','menu-2','menu-3','menu-4','menu-5']);
            $validatorMenu=$this->validatorMenus($dados);
            if($validatorMenu->fails()){
                return response()->json(['error'=>$validatorMenu->errors()->all()]);
            }else{
                $this->atualizarMenus($dados);
            }
        }
        
        if($request->has('corMenu') || $request->has('corFonte') 
            || $request->has('corPagina') ){
           
            $coresMenu=$request->only(['corMenu','corFonte','corPagina']);
           $this->atualizarCoresMenu($coresMenu);
        }
        
        if($request->has('logoFoto')){
            if($request->file('logoFoto')->isValid()){
                $validatorImage=$this->validatorImageLogo($request->only('logoFoto'));
                
                if($validatorImage->fails()){
                    return response()->json(['error'=>$validatorImage->errors()->all()]);
                }else{
                    $this->atualizarLogo($request);
                }
            }
        }

        if($request->has(['sobre','tituloSobre'])){
            $dados=$request->only(['sobre','tituloSobre','bannerAbout']);
            
            $validatorSobre=$this->validatorSobre($dados);

            if($validatorSobre->fails()){
                return response()->json(['error'=>$validatorSobre->errors()->all()]);
            }else{
                $this->atualizarSobre($dados,$request);
            }
        }

        if($request->has(['emailContato','numWhatsApp','numContato',
                'instagramLink','emailLink','pinterestLink'])){
            $dados=$request->only(['emailContato','emailSegundario','numWhatsApp','numContato',
                    'instagramLink','emailLink','pinterestLink','bannerContact']);
            
            $validatorContato=$this->validatorContato($dados);            
            
            if($validatorContato->fails()){
                return response()->json(['error'=>$validatorContato->errors()->all()]);
            }else{
                $this->atualizarContato($dados,$request);
            }
        }
    }

    private function atualizarMenus($dados){
        $key=1;
        foreach($dados as $menu){
            DB::update('UPDATE tbmenus SET titulo=:titulo WHERE numMenu=:numMenu'
                ,[':titulo'=>$menu, ':numMenu'=>$key]);
            $key++;
        }
    }

   private function atualizarLogo($request){
        $image=md5(time().(rand(0,9999).md5(time()))).".".$request->file('logoFoto')->extension();
        $request->file('logoFoto')->storeAs('imagens/configImagens/logo/',$image);
        $antigoLogo=ConfigSite::where('titulo','logo')->first();
        Storage::delete("imagens/configImagens/logo/".$antigoLogo->valor);
        $config=ConfigSite::where('titulo','logo')->first();
        $config->valor=$image;
        $config->save();
    }

    private function atualizarSobre($valor,$request){
        $configSobre=ConfigSite::where('titulo','sobre')->first();
        $configSobre->valor=$valor['sobre'];
        $configSobre->save();

        $configTituloSobre=ConfigSite::where('titulo','tituloSobre')->first();
        $configTituloSobre->valor=$valor['tituloSobre'];
        $configTituloSobre->save();

   
       
        
        if(!empty($valor['bannerAbout'])){
            $antigoBanner=ConfigSite::where('titulo','bannerAbout')->first();
            $antigoBanner=$antigoBanner->valor;
            Storage::delete("imagens/configImagens/bannerAbout/".$antigoBanner);
            
            $image=md5(time().(rand(0,9999).md5(time()))).".".
                    $request->file('bannerAbout')->extension();
            $request->file('bannerAbout')->storeAs('imagens/configImagens/bannerAbout/',$image);

            $configBannerSobre=ConfigSite::where('titulo','bannerAbout')->first();
            $configBannerSobre->valor=$image;
            $configBannerSobre->save();
        }
    }

    private function atualizarCoresMenu($cores){
        $configMenu=ConfigSite::where('titulo','corMenu')->first();
        $configMenu->valor=$cores['corMenu'];
        $configMenu->save();

        $configFonte=ConfigSite::where('titulo','corFonteMenu')->first();
        $configFonte->valor=$cores['corFonte'];
        $configFonte->save();

        $configPagina=ConfigSite::where('titulo','corPagina')->first();
        $configPagina->valor=$cores['corPagina'];
        $configPagina->save();
    }

    private function atualizarContato($dados,$request){
          $configEmailContato=ConfigSite::where('titulo','emailContato')->first();  
          $configEmailContato->valor=$dados['emailContato'];
          $configEmailContato->save();

          $caracteresNumWhats=['(',')',' ','-'];
          $numWhats=str_replace($caracteresNumWhats,'',$dados['numWhatsApp']);
          $configWhats=ConfigSite::where('titulo','whatsApp')->first();  
          $configWhats->valor='55'.$numWhats;
          $configWhats->save();

          $configNumContato=ConfigSite::where('titulo','numContato')->first();  
          $configNumContato->valor=$dados['numContato'];
          $configNumContato->save();

          $configInstagramLink=ConfigSite::where('titulo','instagramLink')->first();  
          $configInstagramLink->valor=$dados['instagramLink'];
          $configInstagramLink->save();

          $configEmailLink=ConfigSite::where('titulo','emailLink')->first();  
          $configEmailLink->valor=$dados['emailLink'];
          $configEmailLink->save();

          $configPonterestLink=ConfigSite::where('titulo','pinterestLink')->first();  
          $configPonterestLink->valor=$dados['pinterestLink'];
          $configPonterestLink->save();

          if(!empty($dados['bannerContact'])){
                $antigoBanner=ConfigSite::where('titulo','bannerContact')->first();
                $antigoBanner=$antigoBanner->valor;
                Storage::delete("imagens/configImagens/bannerContact/".$antigoBanner);
                
                $image=md5(time().(rand(0,9999).md5(time()))).".".
                        $request->file('bannerContact')->extension();
                $request->file('bannerContact')->storeAs('imagens/configImagens/bannerContact/',$image);

                $configBannerContact=ConfigSite::where('titulo','bannerContact')->first();
                $configBannerContact->valor=$image;
                $configBannerContact->save();
          }
          
          if(!empty($dados['emailSegundario'])){
                $configEmailSegundario=ConfigSite::where('titulo','emailSegundario')->first();  
                $configEmailSegundario->valor=$dados['emailSegundario'];
                $configEmailSegundario->save();
          }

           
        
    }

    private function validatorMenus($dados){
       return Validator::make($dados,[
            'menu-1'=>['required','string','max:50'],
            'menu-2'=>['required','string','max:50'],
            'menu-3'=>['required','string','max:50'],
            'menu-4'=>['required','string','max:50'],
            'menu-5'=>['required','string','max:50'],
        ]); 
    }

    private function validatorImageLogo($dados){
        return Validator::make($dados,[
            'logoFoto' => ['image','mimes:jpeg,png,jpg,gif,svg','max:64240'],
        ]);
    }

    
    private function validatorSobre($dados){
        return Validator::make($dados,[
            'sobre' => ['required','string'],
            'tituloSobre' => ['required','string'],
            'bannerAbout' =>['image','mimes:jpeg,png,jpg,gif,svg','max:64240']
        ]);
    }

    private function validatorContato($dados){
        return Validator::make($dados,[
            'emailContato' => ['required','string','email'],
            'numWhatsApp' => ['required','string'],
            'numContato' => ['required','string'],
            'instagramLink' => ['required','string','url'],
            'emailLink' => ['required','string'],
            'pinterestLink' => ['required','string','url'],
            'bannerContact' =>['image','mimes:jpeg,png,jpg,gif,svg','max:64240']
        ]);
    }
}
