<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::OrderBy('id', 'desc')->get();
        $product = $product->map(function ($prod) {
            $prod->name = json_decode($prod->name);
            $prod->description = json_decode($prod->description);
            return $prod;
        });
        return ProductResource::collection($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = validator::make($request->all(), [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'price' => 'required|numeric',
            'discounted_price' => 'required|numeric',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'quantity' => 'required|numeric',
            'image' => 'required|image',
            'status' => 'required|boolean',
            'category_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $imgPath = Storage::putFile('prod', $request->file('image'));
        Product::create([
            'name' => json_encode([
                'en' => $request->name_en,
                'ar' => $request->name_ar,
            ]),
            'price' => $request->price,
            'discounted_price' => $request->discounted_price,
            'description' => json_encode([
                'en' => $request->description_en,
                'ar' => $request->description_ar,
            ]),
            'image' => $imgPath,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);
        return response()->json(['message' => __('lang.product created successfully')], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'product not found'], 404);
        }
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'price' => 'required|numeric',
            'discounted_price' => 'required|numeric',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'image' => 'nullable|image',
            'quantity' => 'required|numeric',
            'status' => 'nullable',
            'category_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $product = Product::find($id);
        if ($request->hasFile('image')) {
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $product->image = Storage::putFile("prod", $request->image);
        }

        $product->name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ]);
        $product->price = $request->price;
        $product->discounted_price = $request->discounted_price;
        $product->description = json_encode([
            'en' => $request->description_en,
            'ar' => $request->description_ar,
        ]);
        $product->quantity = $request->quantity;
        $product->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $product->status;

        $product->category_id = $request->category_id;
        $product->save();
        return response()->json([' message' => __('lang.product updated successfully')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'product not found'], 404);
        }
        if (Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
        $product->delete();
        return response()->json(['message' => __('lang.product deleted successfully')], 200);
    }
}
