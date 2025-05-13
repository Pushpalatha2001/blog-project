@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-2">

    </div>
    <div class="col-sm-8">
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>{{ $data['page_title'] ?? 'Place Order' }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('order_store') }}" method="POST">
                @csrf

                <ul class="list-group mb-3">
                    @foreach($products as $product)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $product->name }}</strong> - ${{ number_format($product->price, 2) }}
                                    <br>
                                    <small class="text-muted">Stock: {{ $product->stock }}</small>
                                </div>
                                <div class="input-group" style="width: 150px;">
                                    <input type="hidden" name="product_ids[]" value="{{ $product->id }}">
                                    <input type="number" name="quantities[]" class="form-control" min="0" max="{{ $product->stock }}" value="0">
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
    </div>
</div>
    </div>
    <div class="col-sm-2">

    </div>

</div>

@endsection
