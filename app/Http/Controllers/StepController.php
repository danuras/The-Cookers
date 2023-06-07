<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Step;

class StepController extends Controller
{
    /**
     * Memasukan data langkah
     */
    public function create(Request $request){
        if (! Gate::allows('create-step', Session::get('recipe_id_r'))) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'value' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $images = ['', '', ''];

        if ($request->file('images1') || $request->file('images2') || $request->file('images3')) {
            $validator = Validator::make($request->all(), [
                'images1' => 'image|mimes:jpeg,png,jpg|max:2048',
                'images2' => 'image|mimes:jpeg,png,jpg|max:2048',
                'images3' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                return $this->requestKurang($validator->errors());
            }
            $i = 0;
            for ($i = 0; $i < 3; $i++) {
                if ($request->file('images' . ($i + 1))) {
                    $file = $request->file('images' . ($i + 1));
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('images/step/images/'), $filename);
                    $images[$i] = 'images/step/images/' . $filename;
                }
            }
        }
        $step = new Step;
        $step->value = $request->value;
        $step->recipe_id = Session::get('recipe_id_r');
        $step->images = json_encode($images);
        $step->save();
        return back();
    }
    /**
     * Mengubah data langkah
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'value' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $step = Step::find($id);
        
        if (! Gate::allows('admin-step', $step)) {
            abort(403);
        }
        
        $images = ['', '', ''];

        if ($request->file('images1') || $request->file('images2') || $request->file('images3')) {
            $validator = Validator::make($request->all(), [
                'images1' => 'image|mimes:jpeg,png,jpg|max:2048',
                'images2' => 'image|mimes:jpeg,png,jpg|max:2048',
                'images3' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                return $this->requestKurang($validator->errors());
            }
            $i = 0;
            for ($i = 0; $i < 3; $i++) {
                if ($request->file('images' . ($i + 1))) {
                    $file = $request->file('images' . ($i + 1));
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('images/step/images/'), $filename);
                    $images[$i] = 'images/step/images/' . $filename;
                }
            }
        }
        $step->value = $request->value;
        $step->images = json_encode($images);
        $step->save();
        return back();
    }
    /**
     * Menghapus data langkah
     */
    public function delete(Step $step){
        if (! Gate::allows('admin-step', $step)) {
            abort(403);
        }
        $step->delete();
        return back();
    }
}
