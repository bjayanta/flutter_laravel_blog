<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function likeOrUnlike(Request $request)
    {
        $post = Post::findOrFail($request->id);

        if(!$post) 
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        $like = $post->likes()->where('user_id', auth()->user()->id)->first();

        // if not liked then like
        if(!$like) 
        {
            Like::create([
                'post_id' => $request->id,
                'user_id' => auth()->user()->id
            ]);

            return response([
                'message' => 'Liked'
            ], 200);
        }

        // else dislike
        $like->delete();

        return response([
            'message' => 'Dislike'
        ], 200);
    }
}
