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
            $cart = CartResource::collection(CartItem::get());
            return $this->apiResource($cart , 'OK', 200);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function store(CartRequest $request)
    {
        try {
            $cart = CartItem::create([
                'user_id'=>$request->user_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
            ]);

            if(!$cart){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Cart Item created successfully',
                'data'=>$cart
            ]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function show($id){

        $cart = new CartResource(CartItem::findOrFail($id));
        return $this->apiResource($cart , 'OK', 200);
    }

    public function update(Request $request,$id)
    {
        try {
            $cart = CartItem::where('id',$id)->first()
            ->update(
                $request->all()
            );

            if (!$cart){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'CartItem updated successfully',
            ]);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }


    public function delete($id){
        $cart = CartItem::findorfail($id);
        $cart->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Cart Item deleted successfully',
        ]);
    }
}
