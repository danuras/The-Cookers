<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /**
     * Mengambil data resep, bahan-bahan resep, langkah-langkah resep, komentar-komentar resep, dan rata-rata rattingnya
     */
    public function showDetail(Recipe $recipe)
    {
        $data['ingredients'] = $recipe->ingredients;
        $data['recipe'] = $recipe;
        $data['steps'] = $recipe->steps;
        $data['comments'] = $recipe->comments;
        $data['avg_ratting'] = $recipe->averageRatting();
        return view('recipes.detail_recipe', $data);
    }

    /**
     * Menampilkan halaman upload image (awal penguploadan resep)
     */
    public function showUploadImage()
    {
        return view('recipes.upload_recipe.upload_image');
    }

    /**
     * fungsi untuk mengupload gambar resep
     */

    public function uploadImage(Request $request)
    {
        $image = '';

        Session::flashInput($request->input());

        if ($request->file('image_url')) {
            $validator = Validator::make($request->all(), [
                'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }
            $file = $request->file('image_url');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images/recipe/image_url/'), $filename);
            $image = 'images/recipe/image_url/' . $filename;
            Session::put('image_url_r', $image);
        }
        return redirect()->route('recipes.upload-recipe-atribute');
    }

    /**
     * menampilkan halaman untuk mengupload atribut resep
     */
    public function showUploadRecipeAtribute()
    {

        if (Session::has(['image_url_r'])) {
            return view('recipes.upload_recipe.upload_recipe_atribute')->with([
                'image_url_r' => Session::get('image_url_r'),
            ]);
        } else {
            return view('recipes.upload_recipe.upload_image');
        }
    }
    /**
     * Mengupload atribut resep
     */
    public function uploadRecipeAtribute(Request $request)
    {
        Session::flashInput($request->input());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|min:30|max:1000',
            'portion' => 'required|numeric|min:0',
            'cooking_time' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $recipe = new Recipe;
        $recipe->name = $request->name;
        $recipe->description =  $request->description;
        $recipe->portion = $request->portion;
        $recipe->cooking_time = $request->cooking_time;
        $recipe->video_url = $request->video_url;
        $recipe->image_url = Session::get('image_url_r');
        $recipe->user_id = Auth::user()->id;
        $recipe->save();
        Session::put('recipe_id_r', $recipe->id);
        return redirect()->route('recipes.upload-recipe-ingredient-and-step');
    }
    /**
     * Menampilkan halaman untuk mengupload bahan-bahan dan langkah-langkah
     */
    public function showUploadIngredientsAndSteps(){
        $recipe_id = Session::get('recipe_id_r');
        $recipe = Recipe::find($recipe_id);
        $data['steps'] = $recipe->steps();
        $data['ingredients'] = $recipe->ingredients();
        return view('recipes.upload_recipe.upload_recipe_ingredients_and_steps', $data);
    }

    /**
     * Menampilkan halaman review_upload_recipe
     */
    public function showReviewUploadRecipe()
    {

        if (
            Session::has([
                'recipe_id_r',
                'image_url_r'
            ])
        ) {
            $recipe = Recipe::find(Session::get('recipe_id_r'));
            $data['recipe'] = $recipe;
            $data['ingredients'] = $recipe->ingredients();
            $data['steps'] = $recipe->steps();
            return view('recipes.upload_recipe.review_upload_recipe', $data);
        } else if (Session::has(['image_url_r'])) {
            return view('recipes.upload_recipe.upload_recipe_atribute')->with([
                'image_url_r' => Session::get('image_url_r'),
            ]);
        } else {
            return view('recipes.upload_recipe.upload_image');
        }
    }
    /**
     * Menampilkan halaman ketika upload bahan-bahan dan langkah-langkah selesai
     */
    public function showFinishUploadRecipe(){
        Session::forget('image_url_r');
        Session::forget('recipe_id_r');
        return view('recipes.upload_recipe.finish');
    }


    /**
     * Menghapus resep
     */
    public function destroy(Recipe $recipe){
        
        if (! Gate::allows('delete-recipe', $recipe)) {
            abort(403);
        }

        $recipe->delete();
        return back();
    }

    /**
     * Menampillkan halaman cari resep
     */
    public function showSearchRecipe($category){
        $recipes = null;
        if($category == 'popular'){
            $recipes = Recipe::select('id', 'image_url', 'name')
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->paginate(25, ['*'], 'recipes');
        } else if($category == 'newest') {
            $recipes = Recipe::select('id', 'image_url', 'name')
            ->orderByDesc('created_at')
            ->paginate(25, ['*'], 'recipes');
        }
        $data['recipes'] = $recipes;
        return view('recipes.search_recipe', $data);
    }

    /**
     * Mencari resep dengan informasi input tidak detail berdasarkan nama dan bahan resep
     */
    public function searchRecipeNotDetail($search){
        $recipes = Recipe::select('id', 'image_url','name')
        ->where([
            ['name', 'like', '%'.$search.'%'],
        ])->orWhereExists(function ($query) use ($search) {
            $query->select(DB::raw(1))
                  ->from('ingredients')
                  ->whereColumn('recipe_id', 'recipes.id')
                  ->where('value', 'like', '%'.$search.'%');
        })
        ->paginate(25, ['*'], 'recipes');
        $data['recipes'] = $recipes;
        return view('recipes.search_recipe', $data);
    }
}