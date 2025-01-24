<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class MainController extends BaseController
{
    public function getHome(){
        return view('mainPageView');
    }

    public function getAboutUs(){
        return view('aboutUs');
    }

    public function getImpressum(){
        return view('impressumView');
    }

    public function getDatenschutz(){
        return view('datenschutzView');
    }

    public function getHilfe(){
        return view('hilfeView');
    }

    public function getSozio(){
        return view('sozioView');
    }

    public function getTeam(){
        return view('teamView');
    }

    public function getTermine(){
        return view('termineView');
    }

    public function getBetreutes(){
        return view('betreutesView');
    }


    public function getKontakt()
    {
        return view('contactView');

    }

    public function getJobs(){
        return view('jobsView');
    }

    public function getKoor(){
        return view('koorView');
    }



}

