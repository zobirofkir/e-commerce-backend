<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function listOrder()
    {
        $userId = Auth::id();
        
        $orders = Order::with('items.product')->where('user_id', $userId)->get();
    
        return OrderResource::collection($orders);
    }

    // Create a new order
    public function createOrder(OrderRequest $request)
    {
        $validatedData = $request->validated();
    
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_status' => 'pending',
            'total_price' => 0, 
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'shiping_address' => $validatedData['shiping_address'],
            'payment_method' => $validatedData['payment_method'],
            'phone' => $validatedData['phone']
        ]);
    
        $total = 0;
    
        foreach ($validatedData['products'] as $productData) {
            $product = Product::find($productData['id']);
            $quantity = $productData['quantity'];
            $price = $product->price * $quantity;
    
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
    
            $total += $price;
        }
    
        $order->update(['total_price' => $total]);
    
        return OrderResource::make($order);
    }
    
    public function getOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return abort(401);
        }

        return OrderResource::make($order);
    }

    public function deleteOrder($id)
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return abort(401);
        }

        $order->items()->delete();

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}
