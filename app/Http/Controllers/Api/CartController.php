<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;

class CartController extends Controller
{
    
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => $request->quantity,
            ]
        );

        return response()->json(['message' => 'تمت إضافة المنتج إلى السلة', 'cart' => $cartItem]);
    }

    /**
     * جلب محتويات السلة
     */
    public function getCart()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        return response()->json([
            'cart' => $cartItems->map(function ($item) {
                return [
                    'product' => new ProductResource($item->product),
                    'quantity' => $item->quantity
                ];
            })
        ]);
    }

    /**
     * تحديث كمية منتج في السلة
     */
    public function updateCart(Request $request, $id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'المنتج غير موجود في السلة'], 404);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'تم تحديث السلة', 'cart' => $cartItem]);
    }

    /**
     * إزالة منتج من السلة
     */
    public function removeFromCart($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'المنتج غير موجود في السلة'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'تمت إزالة المنتج من السلة']);
    }

    /**
     * تفريغ السلة بالكامل
     */
    public function clearCart()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'تم إفراغ السلة بالكامل']);
    }
}
