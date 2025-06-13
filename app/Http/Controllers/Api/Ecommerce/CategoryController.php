<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Trait\TraitApi;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use TraitApi;

    public function index()
    {
        try {
            $order = CategoryResource::collection(Category::get());
            return $this->apiResource($order , 'OK', 200);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function store(CategoryRequest $request)
    {
        try {
            $cart = Category::create([
                'name'=>$request->name,
                'description'=>$request->description,
            ]);

            if(!$cart){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Category created successfully',
                'data'=>$cart
            ]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function show($id){

        $order = new CategoryResource(Category::findOrFail($id));
        return $this->apiResource($order , 'OK', 200);
    }

    public function update(Request $request,$id)
    {
        try {
            $order = Category::where('id',$id)->first()
                ->update(
                    $request->all()
                );

            if (!$order){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Category updated successfully',
            ]);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }


    public function delete($id){
        $cart = Category::findorfail($id);
        $cart->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Category deleted successfully',
        ]);
    }
}
