<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigSite extends Model
{
    protected $table="tbconfigsite";
    protected $primaryKey="idConfig";
    public $timestamps=false; 
}
