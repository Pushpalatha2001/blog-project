@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="text-end mb-3">
        <a href="{{route('product_add')}}" class="btn btn-primary">Add Product</a>
    </div>

    <table id="postsTable" class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Sl. No</th>
                <th>Product Id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product as $index => $product_all)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product_all->id ?? ''}}</td>
                    <td>{{ $product_all->name ?? 'N/A'}}</td>
                    <td>{{ $product_all->price ?? '0'}}</td>
                    <td>{{ $product_all->stock ?? '0'}}</td>
                    <td>
                        @if($product_all->status == 0)
                            <button class="btn btn-success btn-sm">Active</button>
                        @else
                            <button class="btn btn-danger btn-sm">Inactive</button>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('product_edit', $product_all->id) }}" class="btn btn-sm btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>

@endsection

