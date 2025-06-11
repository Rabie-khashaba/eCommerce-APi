<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Trait\TraitApi;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    use TraitApi;

    public function index()
    {
        try {
            $products = CartResource::collection(CartItem::get());
            return $this->apiResource($products , 'OK', 200);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function store(CartRequest $request)
    {
        try {
            $product = CartItem::create([
                'user_id'=>$request->user_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
            ]);

            if(!$product){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Cart Item created successfully',
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
