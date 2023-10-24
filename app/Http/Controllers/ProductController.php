<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Log;

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
    
        return new ProductResource($product);
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'brand' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'nullable|integer',
        'description' => 'nullable|string',
        'description_long' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:9048', 
    ]);
    


    if ($request->hasFile('image') && $request->file('image')->isValid()) {
       
    } else {
 
        if ($request->hasFile('image')) {
            Log::error('File upload error: ' . $request->file('image')->getErrorMessage());
        } else {
            Log::error('No file uploaded with the name "image"');
        }
    }
    
    $imagePath = '';

if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imagePath = $image->store('images', 'public');
}


    $product = new Product([
        'name' => $request->input('name'),
        'brand' => $request->input('brand'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'description' => $request->input('description'),
        'description_long' => $request->input('description_long'),
        'category_id' => $request->input('category_id'),
        'image' => $imagePath,
    ]);

    $product->save();

    return response()->json(['message' => 'Product created'], 201);
}


}
