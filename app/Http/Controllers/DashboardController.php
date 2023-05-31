<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Memanggil halaman dashboard dan menampilkan data resep yang terpopuler dan terbaru dengan paginate bernilai 25, sehingga data yang ditampilkan akan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 
     */
    public function index()
    {
        // Mengambil data resep dengan mengurutkannya berdasarkan jumlah favorit
        // dan memuat jumlah favorit yang terkait dengan setiap resep
        $data['f_recipes'] = Recipe::select('id', 'image_url', 'name')
        ->withCount('favorites')
        ->orderByDesc('favorites_count')
        ->paginate(25, ['*'], 'f_recipes');
        // Mengambil data resep dengan mengurutkannya berdasarkan tanggal dibuatnya
        $data['n_recipes'] = Recipe::select('id', 'image_url', 'name')
        ->orderByDesc('created_at')
        ->paginate(25, ['*'], 'n_recipes');
        // Mengirim data resep ke tampilan "dashboard" dan mengembalikan tampilan tersebut
        return view('dashboard', $data);
    }
}
