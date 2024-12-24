<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class MainController extends BaseController
{
    public function getHome(){
        return view('mainPageView');
    }

}
