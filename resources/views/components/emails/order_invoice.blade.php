<div>
    <h1>Thank you for your order!</h1>
    <p>Order ID: {{ $order->id }}</p>
    <p>Total Amount: {{ $order->total }}</p>

    <h2>Items:</h2>
    <ul>
        @foreach ($order->items as $item)
        <li>{{ $item->name }} - {{ $item->quantity }} x {{ $item->price }}</li>
        @endforeach
    </ul>
</div>