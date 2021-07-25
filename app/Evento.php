<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table="tbeventos";
    protected $primaryKey="idEvento";
    public $timestamps=false; 
}
