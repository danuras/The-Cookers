<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function changeLocale(Request $request)
    {
        Session::put('locale', $request->locale);
       
        $this->loadLocale();
        return redirect('/'.$request->locale);
    }
}