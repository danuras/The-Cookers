<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    /**
     * Mengubah bahasa web sesuai pilihan user
     *
     *
     */
    public function loadLocale()
    {
        App::setLocale(Session::get('locale'));
    }
}