<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function inicia()
    {
        // echo 'Holas desde prueba';
        // $this->layout = '';
        return view('template');    
    }

    public function tabla()
    {
        // echo 'Holas desde prueba';
        // $this->layout = '';
        return view('tabla');    
    }
}
