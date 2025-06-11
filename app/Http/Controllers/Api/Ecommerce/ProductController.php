<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Trait\TraitApi;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    use TraitApi;


    public function index()
    {
        $products = ProductResource::collection(Product::get());
        return $this->apiResource($products , 'OK', 200);
    }
    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create([
                'name'=>$request->name,
                'description'=>$request->description,
                'price'=>$request->price,
                'stock'=>$request->stock,
            ]);

            if(!$product){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Product created successfully',
                'data'=>$product
            ]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function show($id){

        $product = new ProductResource(Product::findOrFail($id));
        return $this->apiResource($product , 'OK', 200);
    }

    public function update(Request $request,$id)
    {
        try {
            $product = Product::where('id',$id);
            $product->update(
                $request->all()
            );

            if (!$product){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Product updated successfully',
            ]);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }


    public function delete($id){
        $product = Product::findorfail($id);
        $product->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Product deleted successfully',
        ]);
    }

}
