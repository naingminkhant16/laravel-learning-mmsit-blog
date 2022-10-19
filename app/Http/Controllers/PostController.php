<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::search()
            ->when(Auth::user()->isAuthor(), fn ($q) => $q->where("user_id", Auth::id()))
            ->when(request('trash'), fn ($q) => $q->onlyTrashed())
            ->latest("id")
            ->paginate(30)->withQueryString();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create', ['links' => [
            'post' => route('post.index'),
            'create post' => ''
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        DB::transaction(function () use ($request) {
            //saving post
            $post = new Post();
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->description = $request->description;
            $post->excerpt = Str::words($request->description, 50, " .....");
            $post->user_id = Auth::id();
            $post->category_id = $request->category;

            if ($request->hasFile('featured_image')) {
                $newName = uniqid() . "_featured_image." . $request->file('featured_image')->extension();
                $request->file('featured_image')->storeAs("public", $newName);
                //            $request->featured_image->storeAs();
                $post->featured_image = $newName;
            }

            $post->save();
            // saving photo
            $savePhotos = [];
            foreach ($request->photos as $key => $photo) {
                // 1.save to storage
                $newName = uniqid() . "_post_photo." . $photo->extension();
                $photo->storeAs("public", $newName);

                $savePhotos[$key] = [
                    'post_id' => $post->id,
                    'name' => $newName
                ];
            }

            // 2.save to db
            // $photo = new Photo();
            // $photo->post_id = $post->id;
            // $photo->name = $newName;
            // $photo->save();
            Photo::insert($savePhotos); //multiple insertaion
        });
        return redirect()->route('post.index')->with("status", $request->title . ' is added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
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
        return view('post.edit', [
            'post' => $post,
            'links' => [
                'post' => route('post.index'),
                'edit post' => ''
            ]
        ]);
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
        if (Gate::denies('update', $post)) {
            return abort(403, "U are not allowed to update");
        }

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description, 50, " .....");
        $post->user_id = Auth::id();
        $post->category_id = $request->category;

        if ($request->hasFile('featured_image')) {
            //delete old photo
            Storage::delete("public/" . $post->featured_image);

            // update and upload new photo
            $newName = uniqid() . "_featured_image." . $request->file('featured_image')->extension();
            $request->file('featured_image')->storeAs("public", $newName);
            //            $request->featured_image->storeAs();
            $post->featured_image = $newName;
        }

        $post->update();

        // saving photo
        if ($request->photos) {
            $savePhotos = [];
            foreach ($request->photos as $photo) {
                // 1.save to storage
                $newName = uniqid() . "_post_photo." . $photo->extension();
                $photo->storeAs("public", $newName);

                // 2.save to db
                // $photo = new Photo();
                // $photo->post_id = $post->id;
                // $photo->name = $newName;
                // $photo->save();
                $savePhotos[] = [
                    'post_id' => $post->id,
                    'name' => $newName
                ];
            }
            Photo::insert($savePhotos);
        }

        return redirect()->route('post.index')->with("status", $post->title . ' is updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->findOrFail($id)->first();
        if (Gate::denies('delete', $post)) {
            return abort(403, "U are not allowed to delete");
        }
        $postTitle = $post->title;
        if (request('delete') === 'force') {
            if (isset($post->featured_image)) {
                Storage::delete("public/" . $post->featured_image);
            }

            foreach ($post->photos as $photo) {
                //remove from storage
                Storage::delete("public/" . $photo->name);

                //delete from table
                // $photo->delete();
            }

            //remove from storage
            // Storage::delete($post->photos->map(fn ($photo) => 'public/' . $photo->name)->toArray());
            //delete from table
            // dd($post->photos->pluck('id'));
            Photo::where('post_id', $post->id)->delete();

            Post::withTrashed()->findOrFail($id)->forceDelete();
            $message = 'permanently deleted';
        } elseif (request('delete') === 'restore') {
            Post::withTrashed()->findOrFail($id)->restore();
            $message = 'restored';
        } else {
            Post::withTrashed()->findOrFail($id)->delete();
            $message = 'deleted';
        }

        return redirect()->route('post.index')->with("status", $postTitle . ' is ' . $message . ' Successfully');
    }
}
