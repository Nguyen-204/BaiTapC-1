<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $key = 'p' . $product->id;
        $currentQuantity = $cart[$key]['quantity'] ?? 0;

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm này hiện đã hết hàng.');
        }

        $desiredQuantity = $currentQuantity + (int) $request->quantity;
        $finalQuantity = min($desiredQuantity, $product->stock);

        if ($finalQuantity <= $currentQuantity) {
            return redirect()->back()->with('error', 'Số lượng trong giỏ đã chạm mức tồn kho hiện tại.');
        }

        $cart[$key] = $this->makeCartItem($product, $finalQuantity);

        session()->put('cart', $cart);

        if ($finalQuantity < $desiredQuantity) {
            return redirect()->back()->with(
                'error',
                'Số lượng đã được giới hạn còn ' . $finalQuantity . ' do vượt quá tồn kho.'
            );
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('cart', []);
        $key = 'p' . $request->product_id;

        if (isset($cart[$key])) {
            $product = Product::findOrFail($request->product_id);

            if ($request->quantity <= 0) {
                unset($cart[$key]);
                session()->put('cart', $cart);

                return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
            }

            if ($product->stock <= 0) {
                unset($cart[$key]);
                session()->put('cart', $cart);

                return redirect()->route('cart.index')->with('error', 'Sản phẩm đã hết hàng và được xóa khỏi giỏ.');
            }

            $finalQuantity = min((int) $request->quantity, $product->stock);
            $cart[$key] = $this->makeCartItem($product, $finalQuantity);
            session()->put('cart', $cart);

            if ($finalQuantity < (int) $request->quantity) {
                return redirect()->route('cart.index')->with(
                    'error',
                    'Số lượng đã được điều chỉnh còn ' . $finalQuantity . ' theo tồn kho hiện tại.'
                );
            }
        }

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart['p' . $id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    private function makeCartItem(Product $product, int $quantity): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'image' => $product->image,
            'stock' => $product->stock,
        ];
    }
}
