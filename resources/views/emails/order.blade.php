<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body>
    <h1>New Order Received</h1>
    <p><strong>Order ID:</strong> {{ $order_id }}</p>
    <p><strong>Name:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Phone:</strong> {{ $phone }}</p>
    <p><strong>Shipping Address:</strong> {{ $shipping_address }}</p>
    <h2>Total Price: MAD {{ $total_price }}</h2> 
    <h2>Order Items:</h2>
    <ul>
        @foreach ($items as $item)
            <li>{{ $item['product_name'] }} - Quantity: {{ $item['quantity'] }} - Prix * 1: MAD {{ $item['price'] }}</li>
        @endforeach
    </ul>
</body>
</html>
