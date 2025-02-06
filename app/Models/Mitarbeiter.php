<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitarbeiter extends Model
{
    protected $table = 'mitarbeiter';
    protected $PrimaryKey = "id";
    public $timestamps = false;

}
