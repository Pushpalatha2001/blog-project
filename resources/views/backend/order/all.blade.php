@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="text-end mb-3">
        <a href="{{route('order_add')}}" class="btn btn-primary">Add Orders</a>
    </div>

    <table id="postsTable" class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Sl. No</th>
                <th>Order Id</th>
                <th>Product Name</th>
                <th>User Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
                @foreach($order->orderItems as $orderItem)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->id ?? '' }}</td>
                        <td>{{ $orderItem->product->name ?? 'N/A' }}</td> <!-- Fixed this line -->
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $orderItem->quantity ?? '0' }}</td>
                        <td>{{ $orderItem->price ?? '0' }}</td>
                        <td>{{ $order->total_price ?? '0' }}</td>
                        <td>
                            @switch($order->status)
                                @case(0)
                                    <button class="btn btn-warning btn-sm">Pending</button>
                                    @break
                                @case(1)
                                    <button class="btn btn-primary btn-sm">Processing</button>
                                    @break
                                @case(2)
                                    <button class="btn btn-success btn-sm">Completed</button>
                                    @break
                                @case(3)
                                    <button class="btn btn-danger btn-sm">Closed</button>
                                    @break
                                @default
                                    <button class="btn btn-secondary btn-sm">Unknown</button>
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

@endsection
