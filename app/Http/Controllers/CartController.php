<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CartResource::collection(Cart::where("user_id", auth()->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            "product_id" => "numeric",
        ]);

        $product = Product::find($fields["product_id"]);

        Cart::create([
            "product_id" => $product->id,
            "user_id" => auth()->user()->id,
            "price" => $product->price,
            "total_price" => $product->price,
            "quantity" => 1
        ]);

        return $this->index();
    }

    /**
     * Increment the quantity of a certain cart item.
     */
    public function incrementQuantity(Request $request, string $id)
    {
        $cart = Cart::find($id);
        $newQuantity = $cart->quantity + 1;
        $cart->update([
            "quantity" => $newQuantity,
            "total_price" => $newQuantity * ((float) $cart->price)
        ]);

        return $this->index();
    }

    /**
     * Decrement the quantity of a certain cart item.
     */
    public function decrementQuantity(Request $request, string $id)
    {
        $cart = Cart::find($id);
        $newQuantity = $cart->quantity - 1;

        if ($newQuantity <= 0) {
            return $this->destroy($id);
        }
        
        $cart->update([
            "quantity" => $newQuantity,
            "total_price" => $newQuantity * ((float) $cart->price)
        ]);

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::destroy($id);

        return $this->index();
    }
}
