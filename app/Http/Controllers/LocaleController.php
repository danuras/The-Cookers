<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    /**
     * Menyimpan perubahan bahasa yang dipilih user
     *
     *
     */
    public function changeLocale(Request $request)
    {
        Session::put('locale', $request->locale);
       
        $this->loadLocale();
        App::setLocale($request->locale);
        return redirect('/');
    }
}