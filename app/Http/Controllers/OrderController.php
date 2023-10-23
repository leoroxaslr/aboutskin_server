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
    public function placeOrder(Request $request) {
        $orderId = Str::random(30);
        $carts = Cart::where("user_id", auth()->user()->id)->get();
        $orders = [];
        $status = $request->payment_type === "Debit/Credit Card" ? "Pending" : "For Packaging";

        foreach ($carts as $item) {
            array_push($orders, [
                "user_id" => auth()->user()->id,
                "status" => $status,
                "payment_type" => $request->payment_type,
                "total" => (float) $item->total_price,
                "order_id" => $orderId,
                "product_id" => $item->product_id,
                "quantity" => (int) $item->quantity,
                "created_at" => Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);
        }

        Order::insert($orders);
        Cart::where("user_id", auth()->user()->id)->delete();
        return response([
            "orderId" => $orderId
        ], 201);
    }

    public function getOrders() {
        return Order::select("order_id", "created_at", "status")->where("user_id", auth()->user()->id)->distinct()->get();
    }

    public function getOrderItems(string $id) {
        $order = Order::where("order_id", $id)->get();
        return OrderResource::collection($order);
    }
}
