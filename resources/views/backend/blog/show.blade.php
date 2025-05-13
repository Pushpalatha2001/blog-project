<div class="card mt-5">
    <div class="card-header">💬 Leave a Comment</div>
    <div class="card-body">
        <form id="commentForm">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="mb-3">
                <textarea name="comment" class="form-control" rows="3" placeholder="Your comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <hr>
        <div id="commentList">
            @foreach($post->comments as $comment)
                <p class="mb-1">🗨️ {{ $comment->body }}</p>
            @endforeach
        </div>
    </div>
</div>
<script>
    document.getElementById('commentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("{{ route('comments.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.querySelector('[name="comment"]').value = '';
                const newComment = document.createElement('p');
                newComment.textContent = '🗨️ ' + data.comment.body;
                document.getElementById('commentList').prepend(newComment);
            }
        });
    });
</script>
