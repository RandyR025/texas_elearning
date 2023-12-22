<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandlerController extends Controller
{
    public function HakAkses(){
        return view('backend/handler.hakakses');
    }
}
