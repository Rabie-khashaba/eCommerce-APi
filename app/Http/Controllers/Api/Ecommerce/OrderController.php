<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Trait\TraitApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();

            $items = CartItem::with('product')->where('user_id',auth()->user()->id)->get();
            $total_price = $items->sum(fn($item) => $item->product->price * $item->quantity);

//            return response()->json([
//                'data'=>$items
//            ]);


            $order = Order::create([
                'user_id'=>auth()->user()->id,
                'total_price'=>$total_price,
                'status'=>'Pending',
            ]);

            foreach ($items as $item){
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$item->product->id,
                    'quantity'=>$item->quantity,
                    'unit_price'=>$item->product->price,
                    'total_price'=>$total_price,
                ]);
            }

            CartItem::where('user_id',auth()->user()->id)->delete();



            DB::commit();
            return response()->json([
                'success'=>true,
                'message'=>'Order created successfully',
                'data'=>$order
            ]);




        }catch (\Exception $exception){
            DB::rollBack();
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
