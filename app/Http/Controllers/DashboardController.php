<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Memanggil halaman dashboard dan menampilkan data resep yang terpopuler dan terbaru dengan paginate bernilai 4, sehingga data yang ditampilkan akan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 
     */
    public function index()
    {
        
        Session::forget('image_url_r');
        Session::forget('r_name');
        Session::forget('r_description');
        Session::forget('r_portion');
        Session::forget('r_cooking_time');
        Session::forget('r_video_url');
        Session::forget('r_steps');
        Session::forget('r_ingredients');
        if (auth()->check()) {
            // Mengambil data resep dengan mengurutkannya berdasarkan tanggal dibuatnya
            $data['n_recipes'] = Recipe::select('id', 'image_url', 'name')
                ->orderByDesc('created_at')
                ->paginate(24, ['*'], 'n_recipes');
            // Mengirim data resep ke tampilan "dashboard" dan mengembalikan tampilan tersebut
            return view('home', $data);
        } else {
            return view('dashboard');
        }
    }
}