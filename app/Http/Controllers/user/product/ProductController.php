<?php

namespace App\Http\Controllers\user\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users\product\Product as ProductForUser;
use Product;

class ProductController extends Controller
{
    public function index(Request $request){
        return ProductForUser::find($request->id);
    }
    public function store(Request $request){
        ProductForUser::create([
            'created_by' => $request->user_id,
            'activity' => true,
            'category_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'sub_category_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'name' => $request->name,
            'chemical_class_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'active_substance_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'price' => 100,
            'discount' => 10,
        ]);
        try {
            return response()->json([
                'message' => 'product added'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
    public function all(Request $request){
        return ProductForUser::all();
    }

    public function destroy(Request $request){
        ProductForUser::destroy($request->id);
    }
    public function update(Request $request){
        ProductForUser::where('id', $request->id)
        ->updated([
            'activity' => true,
            'category_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'sub_category_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'name' => $request->name,
            'chemical_class_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'active_substance_id' => "CBBC2374-54F8-4DA2-B361-E3AEBDBF984F",
            'price' => 100,
            'discount' => 10,
        ]);
    }
}
