<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    /**
     * Menyimpan data ingredient
     */
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'recipe_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $ingredient = new Ingredient;
        $ingredient->value = $request->value;
        $ingredient->recipe_id = $request->recipe_id;
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
        $ingredient->value = $request->value;
        $ingredient->recipe_id = $request->recipe_id;
        $ingredient->save();
        return back();
    }
    /**
     * Meghapus data ingredient
     */
    public function delete(Ingredient $ingredient){
        $ingredient->delete();
        return back();
    }
}
