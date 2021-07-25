<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{
    protected $table="tbartigos";
    protected $primaryKey="idArtigo";
    public $timestamps=false; 
}
