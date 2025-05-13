@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Blog Post</h2>
        <!-- Dark Mode Toggle -->
        <div>
            <!-- Toggle Switch for Dark Mode -->
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="toggleDark">
                <label class="custom-control-label" for="toggleDark"></label>
            </div>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <form method="POST" action="{{ route('update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$post->id}}">

                <!-- Title -->
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <label for="title" class="form-label fw-semibold">Title</label>
                    </div>
                    <div class="col-sm-6">
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ $post->title ?? 'N/A' }}" required>
                        @error('title')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image -->
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <label for="image" class="form-label fw-semibold">Image</label>
                    </div>
                    <div class="col-sm-6">
                        <input name="image" class="form-control" type="file" id="image" onchange="previewImage(event)">

                        <!-- Display current image if available -->
                        @if($post->image)
                            <div class="mt-2">
                                <img id="imagePreview" src="{{ asset('storage/images/' . $post->image) }}" alt="Current Image" width="100" height="100">
                            </div>
                            <input type="hidden" name="image_hidden" value="{{ $post->image }}">
                        @else
                            <div class="mt-2">
                                <img id="imagePreview" src="#" alt="Image Preview" width="100" height="100" style="display: none;">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <label for="description" class="form-label fw-semibold">Short Description</label>
                    </div>
                    <div class="col-sm-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ $post->description ?? 'N/A' }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-6 text-end">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </div>

            </form>
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
    document.getElementById('toggleDark').addEventListener('change', function () {
        document.body.classList.toggle('dark-mode', this.checked);
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
