<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SobreController extends Controller
{
    public function __invoke(){
        return view('Site.sobre');
    }
}
