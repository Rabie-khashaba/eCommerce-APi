<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Trait\TraitApi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use TraitApi;

    public function index()
    {
        try {
            $order = OrderResource::collection(Order::get());
            return $this->apiResource($order , 'OK', 200);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function store(OrderRequest $request)
    {
        try {
            $cart = Order::create([
                'user_id'=>$request->user_id,
                'total_price'=>$request->total_price,
//                'status'=>$request->status,
            ]);

            if(!$cart){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'success'=>true,
                'message'=>'Order created successfully',
                'data'=>$cart
            ]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function show($id){

        $order = new OrderResource(Order::findOrFail($id));
        return $this->apiResource($order , 'OK', 200);
    }

    public function update(Request $request,$id)
    {
        try {
            $order = Order::where('id',$id)->first()
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
                'message'=>'Order updated successfully',
            ]);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }


    public function delete($id){
        $cart = Order::findorfail($id);
        $cart->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Order deleted successfully',
        ]);
    }
}
