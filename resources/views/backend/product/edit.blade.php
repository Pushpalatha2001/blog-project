@extends('layouts.app')

@section('content')

<style>
    body.dark-mode {
        background-color: #121212;
        color: #e0e0e0;
    }

    .dark-mode .card {
        background-color: #1e1e1e;
        color: #fff;
        border: 1px solid #333;
    }

    .dark-mode .form-control {
        background-color: #2b2b2b;
        color: #fff;
        border-color: #444;
    }

    .dark-mode .form-control:focus {
        background-color: #2b2b2b;
        color: #fff;
        border-color: #777;
    }
</style>

<div class="row">
    <div class="col-sm-2"></div>

    <div class="col-sm-8">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Edit Product</h2>
                <!-- Dark Mode Toggle -->
                 
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="toggleDark">
                    <label class="custom-control-label" for="toggleDark"></label>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-body">
                    <form method="POST" action="{{ route('product_update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id ?? '' }}">

                        <div class="row mb-4">
                            <!-- Product Name -->
                            <div class="col-sm-4">
                                <label for="name" class="form-label fw-semibold">Product Name</label>
                            </div>
                            <div class="col-sm-6">
                                <input name="name" id="name" type="text" placeholder="Enter product"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $product->name ?? '' }}" required>
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Price -->
                            <div class="col-sm-4">
                                <label for="price" class="form-label fw-semibold">Price</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="price" id="price"
                                    value="{{ $product->price ?? '0' }}" required>
                                @error('price')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Stock -->
                            <div class="col-sm-4">
                                <label for="stock" class="form-label fw-semibold">Stock</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="stock" id="stock"
                                    value="{{ $product->stock ?? '0' }}" required>
                                @error('stock')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Description -->
                            <div class="col-sm-4">
                                <label for="description" class="form-label fw-semibold">Description</label>
                            </div>
                            <div class="col-sm-6">
                                <textarea name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    rows="2" placeholder="Description">{{ $product->description ?? '' }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Status -->
                            <div class="col-sm-4">
                                <label for="status" class="form-label fw-semibold">Status</label>
                            </div>
                            <div class="col-sm-6">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="0" {{ isset($product) && $product->status == 0 ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ isset($product) && $product->status == 1 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-6 text-end">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-2"></div>
</div>

<script>
    // Dark mode toggle with persistence
    const toggleDark = document.getElementById('toggleDark');
    if (localStorage.getItem('dark-mode') === 'enabled') {
        document.body.classList.add('dark-mode');
        toggleDark.checked = true;
    }

    toggleDark.addEventListener('change', () => {
        if (toggleDark.checked) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('dark-mode', 'disabled');
        }
    });

    $(document).ready(function () {
        $('#status').select2(); // Apply Select2 on status field
    });
</script>

@endsection
