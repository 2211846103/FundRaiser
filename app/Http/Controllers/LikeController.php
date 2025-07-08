<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Project;
use DB;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function storeComment(LikeRequest $request)
    {
        $data = $request->validated();

        $comment = Comment::findOrFail($data['comment_id']);

        $like = Like::where('user_id', auth()->user()->id)
            ->where('comment_id', $data['comment_id'])
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'comment_id' => $data['comment_id'],
                'project_id' => null
            ]);
            $liked = true;
        }

        $count = $comment->likedUsers()->count();

        return response()->json([
            'liked' => $liked,
            'likes' => $count,
        ]);
    }

    public function storeProject(LikeRequest $request)
    {
        $data = $request->validated();

        $like = Like::where('user_id', auth()->user()->id)
            ->where('project_id', $data['project_id'])
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'project_id' => $data['project_id'],
                'comment_id' => null
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked
        ]);
    }
}
