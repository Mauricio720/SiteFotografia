<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table="tbfotos";
    protected $primaryKey="idFoto";
    public $timestamps=false;
}
