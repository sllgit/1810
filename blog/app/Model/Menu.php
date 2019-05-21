<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menu";
    public $timestamps = false;
    protected $primaryKey = 'id';
}
