<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $orderId = Str::random(30);
        $carts = Cart::where("user_id", auth()->user()->id)->get();
        $orders = [];
        $status = $request->payment_type === "Debit/Credit Card" ? "Pending" : "For Packaging";
        $totalPrice = 0; // Initialize the total price variable.

        foreach ($carts as $item) {
            array_push($orders, [
                "user_id" => auth()->user()->id,
                "status" => $status,
                "payment_type" => $request->payment_type,
                "total" => (float) $item->total_price,
                "order_id" => $orderId,
                "product_id" => $item->product_id,
                "quantity" => (int) $item->quantity,
                "weight" => (float) $item->weight,
                "length" => (float) $item->length,
                "width" => (float) $item->width,
                "height" => (float) $item->height,
                "item_type" => "Cosmetics", 
                "phone_number" => auth()->user()->phone_num,
                "postal_code" => auth()->user()->postal,
                "address" => auth()->user()->address,
                "customer_name" => auth()->user()->username,
                "customer_order_number" => "Your Order Number", 
                "created_at" => Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
        ]);

            $totalPrice += (float) $item->total_price; // Calculate the total price.
        }

        Order::insert($orders);
        Cart::where("user_id", auth()->user()->id)->delete();

        return response([
            "orderId" => $orderId,
            "totalPrice" => $totalPrice, // Pass the total price to the response.
        ], 201);
    }

    public function getOrders() {
        return Order::select("order_id", "created_at", "status")->where("user_id", auth()->user()->id)->distinct()->get();
    }
    public function getOrdersAdmin() {
    $orders =Order::select('*')
        ->get()
        ->groupBy(function ($date) {
            return $date->created_at->format('Y-m-d');
        });

    return $orders;
}
    public function getOrderItems(string $id) {
        $order = Order::where("order_id", $id)->get();
        return OrderResource::collection($order);
    }
}
