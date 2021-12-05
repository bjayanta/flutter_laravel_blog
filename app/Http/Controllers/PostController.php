<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'posts' => Post::orderBy('created_at', 'desc')->with('user:id,name,image')->withCount('comments', 'likes')->get()
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
        // validation
        $attributies = $request->validate([
            'body' => 'required|string'
        ]);

        $post = Post::create([
            'body' => $attributies['body'],
            'user_id' => auth()->user()->id
        ]);

        return response([
            'message' => 'Post has been created successfully',
            'post' => $post
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
        return response([
            'post' => Post::where('id', $id)->withCount('comments', 'like')->get()
        ], 200);
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
        $post = Post::findOrFail($id);

        if(!$post) 
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        if($post->user_id != auth()->user()->id) 
        {
            return response([
                'message' => 'Permission denied..'
            ], 403);
        }

        // validation
        $attributies = $request->validate([
            'body' => 'required|string'
        ]);

        $post->update([
            'body' => $attributies['body']
        ]);

        return response([
            'message' => 'Post has been created successfully',
            'post' => $post
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
        $post = Post::findOrFail($id);

        if(!$post) 
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        if($post->user_id != auth()->user()-id) 
        {
            return response([
                'message' => 'Permission denied..'
            ], 403);
        }

        // $post->comments()->delete();
        // $post->likes()->delete();
        $post->delete();

        return response([
            'message' => 'Post has been deleted successfully'
        ], 200);
    }
}
