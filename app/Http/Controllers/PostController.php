<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::when(request('search'), function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
        })
            ->when(Auth::user()->isAuthor(), fn ($q) => $q->where('user_id', Auth::id()))
            ->latest('id')
            ->with(['category', 'user'])
            ->paginate(10)
            ->withQueryString();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //store post data from input request
        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->body = $request->body;
        $post->excerpt = Str::excerpt($request->body);
        $post->user_id = Auth::id();
        $post->category_id = $request->category;

        //check featured image includes in store,if it does store image
        if ($request->hasFile('featured_image')) {
            $newName = uniqid() . '_featured_image.' . $request->file('featured_image')->extension();
            //store image to storage
            $request->file('featured_image')->storeAs('public', $newName);
            //store image name to db
            $post->featured_image = $newName;
        };

        $post->save(); //finish post create here

        //saving photos
        foreach ($request->photos as $photo) {
            //1 - save data to storage
            $newName = uniqid() . '_post_photo.' . $photo->extension();
            //store post photo to storage with new name
            $photo->storeAs('public', $newName);

            //2 - save to db
            $photo = new Photo();
            $photo->post_id = $post->id;
            $photo->name = $newName;
            $photo->save();
        }

        return redirect()->route('post.index')->with('status', $post->title . " is created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // return $post->user;

        Gate::authorize('view', $post);
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //check gate
        if (Gate::denies('update', $post)) {
            return abort(403, "U are not allowed to edit!");
        };

        //update post data
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->body = $request->body;
        $post->excerpt = Str::excerpt($request->body);
        $post->user_id = Auth::id();
        $post->category_id = $request->category;

        //check featured image includes in update,if it does ,delete old and update
        if ($request->hasFile('featured_image')) { //check featured image from input request
            //delete old image from Storage
            Storage::delete('public/' . $post->featured_image);
            //update new image
            $newName = uniqid() . '_featured_image.' . $request->file('featured_image')->extension();
            //update new image in storage
            $request->file('featured_image')->storeAs('public', $newName);
            //update new image in db
            $post->featured_image = $newName;
        };
        //update post
        $post->update();

        //saving photos
        if (isset($request->photos)) {
            foreach ($request->photos as $photo) {
                //1 - save photos to storage
                $newName = uniqid() . '_post_photo.' . $photo->extension();
                $photo->storeAs('public', $newName);

                //2 - save photos to db
                $photo = new Photo();
                $photo->post_id = $post->id;
                $photo->name = $newName;
                $photo->save();
            }
        }

        return redirect()->route('post.index')->with('status', $post->title . " is updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //check gate
        if (Gate::denies('delete', $post)) return abort(403, "U are not allowed to delete");

        $oldTitle = $post->title; //for feedback

        //check featured image exists , if it does ,find and delete from storage
        if (isset($post->featured_image) && file_exists(storage_path('app/public/' . $post->featured_imgae))) {
            Storage::delete('public/' . $post->featured_image); //delete old imgae
        }

        //delete post photots from photo table
        foreach ($post->photos as $photo) {
            //delete photo from storage
            Storage::delete('public/' . $photo->name);
            //delete photo from db
            $photo->delete();
        };
        //finally delete post
        $post->delete();
        return redirect()->route('post.index')->with('status', $oldTitle . " is deleted successfully.");
    }
}
