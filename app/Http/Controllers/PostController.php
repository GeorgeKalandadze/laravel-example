<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json(['data' => $posts], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated->title,
            'body' => $validated->body,
        ]);

        return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json(['data' => $post], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return response()->json(['message' => 'Post updated successfully', 'data' => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
