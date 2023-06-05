<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GroupIngredient;
use App\Models\Ingredient;
use App\Models\Ratting;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /**
     * Mengambil data resep, bahan-bahan resep, langkah-langkah resep, komentar-komentar resep, dan rata-rata rattingnya
     */
    public function showDetail(Recipe $recipe)
    {
        $groups = GroupIngredient::where('recipe_id', $recipe->id)->get();
        $groupIngredients = [];

        foreach ($groups as $group) {
            array_push(
                $groupIngredients,
                $group->ingredients,
            );
        }

        $data['groupIngredients'] = $groupIngredients;
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
        return redirect()->intended('show-upload-recipe-atribute');
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
            'country_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        Session::put('name_r', $request->name);
        Session::put('description_r', $request->description);
        Session::put('portion_r', $request->portion);
        Session::put('cooking_time_r', $request->cooking_time);
        Session::put('country_id_r', $request->country_id);
        return redirect()->intended('show-review-upload-recipe');
    }

    /**
     * Menampilkan halaman review_upload_recipe
     */
    public function showReviewUploadRecipe()
    {

        if (
            Session::has([
                'name_r',
                'description_r',
                'portion_r',
                'cooking_time_r',
                'country_id_r',
                'image_url_r',
            ])
        ) {
            return view('recipes.upload_recipe.review_upload_recipe')->with([
                'image_url_r' => Session::get('image_url_r'),
                'name_r' => Session::get('name_r'),
                'description_r' => Session::get('description_r'),
                'portion_r' => Session::get('portion_r'),
                'cooking_time_r' => Session::get('cooking_time_r'),
                'country_id_r' => Session::get('country_id_r'),
            ]);
        } else if (Session::has(['image_url_r'])) {
            return view('recipes.upload_recipe.upload_recipe_atribute')->with([
                'image_url_r' => Session::get('image_url_r'),
            ]);
        } else {
            return view('recipes.upload_recipe.upload_image');
        }
    }
    /**
     * Mensubmit/menyimpan data resep yang diinputkan user ke database
     * lalu menampilkan halaman finish
     */
    public function submitRecipe(Request $request)
    {
        $recipe = new Recipe;
        $recipe->name = Session::get('name_r');
        $recipe->description = Session::get('description_r');
        $recipe->portion = Session::get('portion_r');
        $recipe->cooking_time = Session::get('cooking_time_r');
        $recipe->country_id = Session::get('country_id_r');
        $recipe->image_url = Session::get('image_url_r');
        $recipe->save();
        Session::forget('name_r');
        Session::forget('description_r');
        Session::forget('portion_r');
        Session::forget('cooking_time_r');
        Session::forget('country_id_r');
        Session::forget('image_url_r');
        return view('recipes.upload_recipe.finish');
    }
}