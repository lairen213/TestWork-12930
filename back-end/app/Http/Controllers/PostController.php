<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPosts(Request $request)
    {
        $limit = 10;
        $page = 1;
        if($request->get('_page'))
            $page = $request->get('_page');
        if($request->get('_limit'))
            $limit = $request->get('_limit');

        $posts = Post::where('deleted', 0)->paginate($limit, ['*'], 'page', $page);

        return response()->json(['status' => 'ok', 'total_pages' => $posts->lastPage(), 'data' => $posts->items()]);
    }

    public function getPost($id)
    {
        $post = Post::where('deleted', 0)->where('id', $id)->first();

        return response()->json(['status' => 'ok', 'data' => $post]);
    }

    public function createPost(Request $request)
    {
        if (!$request->get('title') || !$request->get('description')) {
            return response()->json(['status' => 'error', 'data' => 'Enter all required data!']);
        } else {
            $post = new Post([
                'title' => $request->get('title'),
                'description' => $request->get('description')
            ]);
            $post->save();

            return response()->json(['status' => 'ok', 'data' => $post['id']]);
        }
    }

    public function updatePost($id, Request $request)
    {
        $post = Post::where('deleted', 0)->where('id', $id)->first();

        if ($post) {
            if ($request->get('title')) {
                $post->update(['title' => $request->get('title')]);
            }
            if ($request->get('description')) {
                $post->update(['description' => $request->get('description')]);
            }
            $post->save();
            return response()->json(['status' => 'ok', 'data' => '']);
        } else {
            return response()->json(['status' => 'error', 'data' => 'Post not found!']);
        }
    }

    public function deletePost($id){
        $post = Post::where('deleted', 0)->where('id', $id)->first();
        if($post){
            $post->update(['deleted' => 1]);
            $post->save();

            return response()->json(['status' => 'ok', 'data' => '']);
        }
        else{
            return response()->json(['status' => 'error', 'data' => 'Post not found!']);
        }
    }
}
