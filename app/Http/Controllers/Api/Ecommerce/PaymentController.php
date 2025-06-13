<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Models\Payment;
use App\Trait\TraitApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    use TraitApi;

    public function index()
    {
        try {
            $payment = PaymentResource::collection(Payment::get());
            return $this->apiResource($payment , 'OK', 200);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function pay(PaymentRequest $request)
    {

//        Stripe::setApiKey(config('services.stripe.secret'));
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            DB::beginTransaction();

            $order = Order::findOrFail($request->order_id);

            $charge = Charge::create([
                'amount' => $order->total_price * 100, // in cents
                'currency' => 'usd',
                'description' => 'Order #' . $order->id,
                'source' => $request->token, // from
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                ]
            ]);


            $payment = Payment::create([
                'order_id'=>$request->order_id,
                'payment_method'=>'stripe',
                'payment_status'=>'paid',
                'transaction_id'=>$charge->id,
                'amount'=>$order->total_price ,
                'paid_at'=>now(),
            ]);

            $order->update(['status'=>'paid']);

            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'Payment created successfully',
                'data'=>$charge
            ]);




        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

    }

    public function show($id){

        $order = new PaymentResource(Payment::findOrFail($id));
        return $this->apiResource($order , 'OK', 200);
    }


    public function delete($id){
        $payment = Payment::findorfail($id);
        $payment->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Payment deleted successfully',
        ]);
    }
}
