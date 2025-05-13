@extends('layouts.app')

@section('content')
<style>
    body.bg-dark a, 
body.bg-dark .card a {
    color: #90caf9 !important;
}

.modal-content.bg-dark {
    background-color: #2c2c2c;
}

</style>
<div class="container py-4">
    <div class="text-end mb-3">
        <a href="/create" class="btn btn-primary">Add New Post</a>
    </div>
    <table id="postsTable" class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Sl. No</th>
                <th>Post ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Comment</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $index => $post)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ Str::limit($post->description, 50) }}</td>
                    <td>
                        @foreach($post->comments as $comment)
                            <div>{{ $comment->comment }}</div>
                        @endforeach
                    </td>
                    <td>
                        @if($post->image)
                            <img src="{{ asset('storage/images/' . $post->image) }}" alt="Image" width="50" height="50">
                        @endif
                    </td>
                    <td>
                        <a href="#"
                           class="btn btn-sm btn-primary openCommentModal"
                           data-bs-toggle="modal"
                           data-bs-target="#commentModal"
                           data-post-id="{{ $post->id }}">
                           Comment
                        </a>
                        <a href="{{ route('edit', $post->id) }}" class="btn btn-sm btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Leave a Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="commentForm">
                    @csrf
                    <input type="hidden" name="post_id" id="modalPostId">
                    <div class="mb-3">
                        <textarea name="comment" class="form-control" rows="3" id="comment" placeholder="Your comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success comment_submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
$(document).ready(function () {
    $('.openCommentModal').on('click', function (e) {
        e.preventDefault();
        
        var selectedPostId = $(this).data('post-id');
        
        $('#modalPostId').val(selectedPostId);
    });

    $('#commentForm').on('submit', function (e) {
        e.preventDefault();

        const selectedPostId = $('#modalPostId').val();

        const formData = {
            _token: "{{ csrf_token() }}", 
            comment: $('#comment').val(),
            post_id: selectedPostId
        };

        $.ajax({
            url: "{{ route('comment_store') }}",  
            method: "POST",
            data: formData,
            success: function (data) {
                if (data.success) {
                    const postCard = $(`[data-post-id="${selectedPostId}"]`).closest('.card-body');

                    postCard.find('.text-comment').append(`<p class="mb-1">${data.comment.comment}</p>`);

                    $('#comment').val('');

                    $('#commentModal').modal('hide'); 
                }
            },
            error: function () {
                alert('Something went wrong while saving the comment.');
            }
        });
    });
});
</script>
@endsection

