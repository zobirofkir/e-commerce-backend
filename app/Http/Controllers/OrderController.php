<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function createOrder(OrderRequest $request)
    {
        $validatedData = $request->validated();
    
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_status' => 'pending',  
            'total_price' => 0, 
            'shiping_address' => $validatedData['shiping_address'],
            'payment_method' => $validatedData['payment_method']
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
    
        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order
        ], 201);
    }
    

    public function getOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return response()->json($order);
    }
}
