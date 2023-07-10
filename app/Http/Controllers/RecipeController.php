<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Rules\YoutubeValidLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mavinoo\Batch\BatchFacade as Batch;

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
        $validator = Validator::make($request->all(), [
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ]);

        if ($validator->fails()) {
            if (Session::get('image_url_r')) {
                return redirect()->route('recipes.upload-recipe-atribute');
            }
            return back()->withErrors($validator->errors());
        }
        $file = $request->file('image_url');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('images/recipe/image_url/'), $filename);
        $image = 'images/recipe/image_url/' . $filename;
        Session::put('image_url_r', $image);
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
            return redirect()->route('recipes.upload-image');
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
            'description' => 'required|max:5000',
            'portion' => 'required|numeric|min:0',
            'cooking_time' => 'required|numeric|min:0',
            'steps' => 'required',
            'ingredients' => 'required',
            'video_url' => ['required',new YoutubeValidLink],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        Session::put('r_name', $request->name);
        Session::put('r_description', $request->description);
        Session::put('r_portion', $request->portion);
        Session::put('r_cooking_time', $request->cooking_time);
        Session::put('r_video_url', $request->video_url);
        Session::put('r_steps', array_map('trim', explode("\n", $request->steps)));
        Session::put('r_ingredients', array_map('trim', explode("\n", $request->ingredients)));

        return redirect()->route('recipes.review-upload-recipe');
    }

    /**
     * Menampilkan halaman review_upload_recipe
     */
    public function showReviewUploadRecipe()
    {

        if (
            Session::has([
                'r_name',
                'r_description',
                'r_portion',
                'r_cooking_time',
                'r_steps',
                'r_ingredients',
                'image_url_r'
            ])
        ) {
            $data['ingredients'] = Session::get('r_ingredients');
            $data['steps'] = Session::get('r_steps');
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
    public function showFinishUploadRecipe()
    {
        if (Session::has(['image_url_r'])) {
            $recipe = new Recipe;
            $recipe->name = Session::get('r_name');
            $recipe->description = Session::get('r_description');
            $recipe->portion = Session::get('r_portion');
            $recipe->cooking_time = Session::get('r_cooking_time');
            $recipe->image_url = Session::get('image_url_r');
            $recipe->video_url = Session::get('r_video_url');
            $recipe->user_id = Auth::user()->id;
            $recipe->save();
            $steps = [];
            $los = Session::get('r_steps');
            for ($i = 0; $i < sizeof($los); $i++) {
                array_push($steps, [
                    'value' => $los[$i],
                    'recipe_id' => $recipe->id,
                ]);
            }
            $ingredients = [];
            $loi = Session::get('r_ingredients');
            for ($i = 0; $i < sizeof($loi); $i++) {
                array_push($ingredients, [
                    'value' => $loi[$i],
                    'recipe_id' => $recipe->id,
                ]);
            }
            Step::insert($steps);
            Ingredient::insert($ingredients);
            Session::forget('image_url_r');
            Session::forget('r_name');
            Session::forget('r_description');
            Session::forget('r_portion');
            Session::forget('r_cooking_time');
            Session::forget('r_video_url');
            Session::forget('r_steps');
            Session::forget('r_ingredients');
        }
        return view('recipes.upload_recipe.finish');
    }

    /**
     * Menghapus resep
     */
    public function destroy(Recipe $recipe)
    {
        if (!Gate::allows('admin-recipe', $recipe)) {
            abort(403);
        }

        $recipe->delete();
        return back();
    }

    /**
     * Menampillkan halaman cari resep
     */
    public function showSearchRecipe()
    {
        $recipes = Recipe::select('id', 'image_url', 'name')
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->paginate(24, ['*'], 'recipes');
        $data['recipes'] = $recipes;
        return view('recipes.search_recipe', $data);
    }

    /**
     * Mencari resep dengan informasi input tidak detail berdasarkan nama dan bahan resep
     */
    public function searchRecipeNotDetail($search)
    {
        $recipes = Recipe::select('id', 'image_url', 'name')
            ->where([
                ['name', 'like', '%' . $search . '%'],
            ])->orWhereExists(function ($query) use ($search) {
                $query->select(DB::raw(1))
                    ->from('ingredients')
                    ->whereColumn('recipe_id', 'recipes.id')
                    ->where('value', 'like', '%' . $search . '%');
            })
            ->paginate(24, ['*'], 'recipes');
        $data['recipes'] = $recipes;
        return view('recipes.search_recipe', $data);
    }
    /**
     * Mencari resep dengan informasi input tidak detail berdasarkan nama dan bahan resep
     */
    public function searchRecipeDetail($ingredient)
    {
        $recipes = Recipe::select('id', 'image_url', 'name')
            ->whereExists(function ($query) use ($ingredient) {
                $query->select(DB::raw(1))
                    ->from('ingredients')
                    ->whereColumn('recipe_id', 'recipes.id')
                    ->where('value', 'like', '%' . $ingredient . '%');
            })
            ->paginate(24, ['*'], 'recipes');
        $data['recipes'] = $recipes;
        return view('recipes.search_recipe', $data);
    }

    /**
     * Menampilkan resep yang telah dibuat oleh user
     */
    public function showUserRecipe()
    {

        Session::forget('image_url_r');
        Session::forget('r_name');
        Session::forget('r_description');
        Session::forget('r_portion');
        Session::forget('r_cooking_time');
        Session::forget('r_video_url');
        Session::forget('r_steps');
        Session::forget('r_ingredients');
        $recipes = Recipe::select('id', 'image_url', 'name')
            ->where([
                ['user_id', Auth::user()->id],
            ])
            ->paginate(24, ['*'], 'recipes');


        $data['recipes'] = $recipes;
        return view('recipes.user_recipe', $data);
    }

    /**
     * Menampilkan halaman edit image (awal pengeditan resep)
     */
    public function showEditImage(Recipe $recipe)
    {
        if (!Gate::allows('admin-recipe', $recipe)) {
            abort(403);
        }
        Session::put('recipe_id_r', $recipe->id);
        Session::put('image_url_r', $recipe->image_url);
        return view('recipes.edit_recipe.edit_image');
    }

    /**
     * fungsi untuk mengupload gambar resep
     */

    public function editImage(Request $request)
    {
        if (!Gate::allows('admin-recipe', Recipe::find(Session::get('recipe_id_r')))) {
            abort(403);
        }

        $image = '';

        Session::flashInput($request->input());

        $validator = Validator::make($request->all(), [
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ]);

        if ($validator->fails()) {
            if (Session::get('image_url_r')) {
                return redirect()->route('recipes.edit-recipe-atribute');
            }
            return back()->withErrors($validator->errors());
        }
        $file = $request->file('image_url');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('images/recipe/image_url/'), $filename);
        $image = 'images/recipe/image_url/' . $filename;
        Session::put('image_url_r', $image);
        return redirect()->route('recipes.edit-recipe-atribute');
    }

    /**
     * menampilkan halaman untuk mengupload atribut resep
     */
    public function showEditRecipeAtribute()
    {
        if (!Gate::allows('admin-recipe', Recipe::find(Session::get('recipe_id_r')))) {
            abort(403);
        }
        if (Session::has(['image_url_r'])) {
            $recipe = Recipe::find(Session::get('recipe_id_r'));
            Session::put('r_name', $recipe->name);
            Session::put('r_description', $recipe->description);
            Session::put('r_portion', $recipe->portion);
            Session::put('r_cooking_time', $recipe->cooking_time);
            Session::put('r_video_url', $recipe->video_url);
            Session::forget('r_steps');
            Session::forget('r_ingredients');
            $steps = '';
            $los = $recipe->steps;
            for ($i = 0; $i < sizeof($los); $i++) {
                $steps = $steps . '
' . $los[$i]->value;
            }
            $ingredients = '';
            $loi = $recipe->ingredients;
            for ($i = 0; $i < sizeof($loi); $i++) {
                $ingredients = $ingredients . '
' . $loi[$i]->value;
            }
            Session::put('r_steps', $steps);
            Session::put('r_ingredients', $ingredients);

            return view('recipes.edit_recipe.edit_recipe_atribute')->with([
                'image_url_r' => Session::get('image_url_r'),
            ]);
        } else {
            return view('recipes.edit_recipe.edit_image');
        }
    }
    /**
     * Mengupload atribut resep
     */
    public function editRecipeAtribute(Request $request)
    {
        if (!Gate::allows('admin-recipe', Recipe::find(Session::get('recipe_id_r')))) {
            abort(403);
        }
        Session::flashInput($request->input());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|max:5000',
            'portion' => 'required|numeric|min:0',
            'cooking_time' => 'required|numeric|min:0',
            'steps' => 'required',
            'ingredients' => 'required',
            'video_url' => ['required',new YoutubeValidLink],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        Session::put('r_name', $request->name);
        Session::put('r_description', $request->description);
        Session::put('r_portion', $request->portion);
        Session::put('r_cooking_time', $request->cooking_time);
        Session::put('r_video_url', $request->video_url);
        Session::put('r_steps', array_map('trim', explode("\n", $request->steps)));
        Session::put('r_ingredients', array_map('trim', explode("\n", $request->ingredients)));

        Session::put('has_ea', 'true');
        return redirect()->route('recipes.review-edit-recipe');
    }
    /**
     * Menampilkan halaman review_upload_recipe
     */
    public function showReviewEditRecipe()
    {
        if (!Gate::allows('admin-recipe', Recipe::find(Session::get('recipe_id_r')))) {
            abort(403);
        }
        if (
            Session::has([
                'has_ea',
                'r_name',
                'r_description',
                'r_portion',
                'r_cooking_time',
                'r_steps',
                'r_ingredients',
                'image_url_r'
            ])
        ) {
            $data['ingredients'] = Session::get('r_ingredients');
            $data['steps'] = Session::get('r_steps');
            return view('recipes.edit_recipe.review_edit_recipe', $data);
        } else if (Session::has(['image_url_r'])) {
            return view('recipes.edit_recipe.edit_recipe_atribute')->with([
                'image_url_r' => Session::get('image_url_r'),
            ]);
        } else {
            return view('recipes.edit_recipe.edit_image');
        }
    }
    /**
     * Menampilkan halaman ketika Edit resep selesai
     */
    public function showFinishEditRecipe()
    {
        if (Session::has(['image_url_r'])) {
            $recipe = Recipe::find(Session::get('recipe_id_r'));
            $recipe->name = Session::get('r_name');
            $recipe->description = Session::get('r_description');
            $recipe->portion = Session::get('r_portion');
            $recipe->cooking_time = Session::get('r_cooking_time');
            $recipe->image_url = Session::get('image_url_r');
            $recipe->video_url = Session::get('r_video_url');
            $recipe->user_id = Auth::user()->id;
            $recipe->save();
            $steps = [];
            $los = Session::get('r_steps');
            for ($i = 0; $i < sizeof($los); $i++) {
                array_push($steps, [
                    'value' => $los[$i],
                    'recipe_id' => $recipe->id,
                ]);
            }
            $ingredients = [];
            $loi = Session::get('r_ingredients');
            for ($i = 0; $i < sizeof($loi); $i++) {
                array_push($ingredients, [
                    'value' => $loi[$i],
                    'recipe_id' => $recipe->id,
                ]);
            }
            DB::delete('delete from steps where recipe_id = ?', [Session::get('recipe_id_r')]);
            DB::delete('delete from ingredients where recipe_id = ?', [Session::get('recipe_id_r')]);
            Step::insert($steps);
            Ingredient::insert($ingredients);
            Session::forget('image_url_r');
            Session::forget('recipe_id_r');
            Session::forget('has_ea');
            Session::forget('r_description');
            Session::forget('r_portion');
            Session::forget('r_name');
            Session::forget('r_cooking_time');
            Session::forget('r_video_url');
            Session::forget('r_steps');
            Session::forget('r_ingredients');
        }
        return view('recipes.edit_recipe.finish');
    }

}