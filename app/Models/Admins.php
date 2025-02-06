<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model {
    protected $table = 'admins';
    protected $primaryKey = 'id_mit';
    public $timestamps = false;

}

