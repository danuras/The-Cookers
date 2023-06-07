<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    /**
     * Menyimpan data ingredient
     */
    public function create(Request $request){
        if (! Gate::allows('create-ingredient', Session::get('recipe_id_r'))) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'value' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $ingredient = new Ingredient;
        $ingredient->value = $request->value;
        $ingredient->recipe_id = Session::get('recipe_id_r');
        $ingredient->save();
        return back();
    }
    /**
     * Mengupdate data ingredient
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'recipe_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
    
        $ingredient = Ingredient::find($id);
        
        if (! Gate::allows('admin-ingredient', $ingredient)) {
            abort(403);
        }
        $ingredient->value = $request->value;
        $ingredient->save();
        return back();
    }
    /**
     * Meghapus data ingredient
     */
    public function delete(Ingredient $ingredient){
        if (! Gate::allows('admin-ingredient', $ingredient)) {
            abort(403);
        }
        $ingredient->delete();
        return back();
    }
}
