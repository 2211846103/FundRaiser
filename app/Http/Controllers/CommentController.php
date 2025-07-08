<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $data = $request->validated();
        
        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'project_id' => $data['project_id'],
            'parent_id' => $data['parent_id'] ?? null,
            'content' => $data['content']
        ]);

        if ($comment->parent)
            $comment->parent->author->notifyReply($comment);

        return redirect()->back();
    }
}
