<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;

class ProductController extends Controller
{
    public function index() {
        return ProductResource::collection(Product::paginate(20));
    }
  
    public function productPage($id)
    {
        return Product::find($id);
    }

    public function getCategories() {
        return CategoryResource::collection(Category::all());
    }

    public function getFilteredProducts(Request $request) {
        $products = Product::where("name", "LIKE", "%" . $request->query("search") . "%");

        if ($request->query("category") === "0") {
            $products = $products->whereBetween("price", [$request->query("min-price"), $request->query("max-price")]);
        } else {
            $products = $products->where("category_id", $request->query("category"))->whereBetween("price", [(float) $request->query("min-price"), (float) $request->query("max-price")]);
        }

        if ($request->query("sort") === "price") {
            $products = $products->orderBy("price", $request->query("asc"));
        } elseif ($request->query("sort") === "name") {
            $products = $products->orderBy("name", $request->query("asc"));
        } elseif ($request->query("sort") === "rating") {
            $ratingValue = (int) $request->query("rating");
    
            if ($ratingValue >= 1 && $ratingValue <= 5) {
                $products = $products->where("rating", $ratingValue)
                    ->orderBy("rating", $request->query("asc"));
            }
        }

        $products = $products->paginate(20);
        return ProductResource::collection($products);
    }

    public function destroy(string $id)
    {
       Product::destroy($id);
       return ['message' => 'Product Deleted'];
    }
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'

        ]);
        return Product::create($request->all());
    }
}
