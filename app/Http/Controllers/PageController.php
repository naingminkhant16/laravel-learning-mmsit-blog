<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
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
        return view('index', compact('posts'));
    }

    public function detail($slug)
    {
        $post = Post::where('slug', $slug)->with(['user', 'category', 'photos'])->first();
        return view('detail', compact('post'));
    }

    public function postsByCategory(Category $category)
    {
        $posts = Post::when(request('search'), function ($q, $search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            });
        })
            ->where('category_id', $category->id)
            ->latest('id')
            ->with(['category', 'user'])
            ->paginate(10)
            ->withQueryString();
        return view('index', compact('posts', 'category'));

        // return $category;
        // $category = Category::where('slug', $slug)->first();
        // return $category->posts()->with(['user', 'category'])->paginate(10);
    }
}
