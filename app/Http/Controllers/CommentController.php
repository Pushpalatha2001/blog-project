<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
   public function CommentStore(Request $request)
{
    $comment = Comment::create([
        'post_id' => $request->post_id,
        'comment' => $request->comment,
    ]);

    return response()->json(['success' => true, 'comment' => $comment]);
}
}
