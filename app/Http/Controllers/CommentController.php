<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::findOrFail(request()->id);

        if(!$post) 
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        return response([
            'post' => $post->with('comments.user')->get()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::findOrFail($request->id);

        if(!$post) 
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        // validation
        $attributies = $request->validate([
            'comment' => 'required|string'
        ]);

        Comment::create([
            'comment' => $attributies['comment'],
            'post_id' => $request->id,
            'user_id' => auth()->user()->id
        ]);

        return response([
            'message' => 'Comment has been saved successfully.'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if(!$comment) 
        {
            return response([
                'message' => 'Comment not found.'
            ], 403);
        }

        if($comment->user_id != auth()->user()-id) 
        {
            return response([
                'message' => 'Permission denied..'
            ], 403);
        }

        // validation
        $attributies = $request->validate([
            'comment' => 'required|string'
        ]);

        $comment->update([
            'comment' => $attributies['comment']
        ]);

        return response([
            'message' => 'Comment has been updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if(!$comment) 
        {
            return response([
                'message' => 'Comment not found.'
            ], 403);
        }

        if($comment->user_id != auth()->user()-id) 
        {
            return response([
                'message' => 'Permission denied..'
            ], 403);
        }

        $comment->delete();

        return response([
            'message' => 'Comment has been deleted successfully.'
        ], 200);
    }
}
