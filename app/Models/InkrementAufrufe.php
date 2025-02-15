<?php

namespace App\Models;
use Illuminate\Support\Facades\Session;

class InkrementAufrufe
{
    public function __construct() {

        try{
            $dates = Dates::query()->increment("aufrufe",1);
        }catch (\Exception $e){
            Session::flash("error_db", $e->getMessage());
        }

    }

    public function getAufrufe($id) {

        try{
            $dates = Dates::query()->select("aufrufe")->get();
            return $dates;
        }
        catch (\Exception $e){
            Session::flash("error_db", $e->getMessage());
        }
        return false;
    }
}
