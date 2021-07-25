<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $table="tbclientes";
    protected $primaryKey="idCliente";
    public $timestamps=false; 
   
}
