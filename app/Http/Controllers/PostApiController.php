<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function index()
    {
        $posts = Post::when(request('search'), function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
        })->latest('id')
            ->with(['category', 'user'])
            ->paginate(10)
            ->withQueryString();

        return response()->json($posts);
    }

    public function detail($slug)
    {
        $post = Post::where('slug', $slug)->with(['user', 'category', 'photos'])->first();
        return response()->json($post);
    }
}
