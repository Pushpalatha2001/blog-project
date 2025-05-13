@extends('layouts.app')

@section('content')
<div class="container py-5">
   
<div class="row">
    <div class="col-sm-2">

    </div>
     <div class="col-sm-8">
         <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">New Blog Post</h2>
        <!-- Dark Mode Toggle -->
        <div>
            <!-- <button id="toggleDark" class="btn btn-outline-dark">🌙 Dark Mode</button> -->
                <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="toggleDark">
                <label class="custom-control-label" for="toggleDark"></label>
            </div>  
        </div>
    </div>
    <div class="card shadow-lg">
        <div class="card-body">
            <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Title -->
                    <div class="col-sm-4">
                        <label for="title" class="form-label fw-semibold">Title</label>
                    </div>
                    <div class="col-sm-6">
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Image -->
                    <div class="col-sm-4">
                        <label for="image" class="form-label fw-semibold">Image</label>
                    </div>
                    <div class="col-sm-6">
                        <input name="image" class="form-control" type="file" id="image" onchange="previewImage(event)">
                            <div class="mt-2">
                                <img id="imagePreview" src="#" alt="Image Preview" width="100" height="100" style="display: none;">
                            </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Description -->
                    <div class="col-sm-4">
                        <label for="description" class="form-label fw-semibold">Short Description</label>
                    </div>
                    <div class="col-sm-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Description -->
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-6 text-end">
                        <button type="submit" class="btn btn-primary px-4">Save</button>

                    </div>
                </div>

                <!-- Submit -->
                <!-- <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Save</button> -->
                </div>
            </form>
        </div>
    </div>
    </div>
     <div class="col-sm-2">

    </div>

</div>

</div>

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

<script>
    document.getElementById('toggleDark').addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    });
     // Function to preview selected image
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image preview
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection  
